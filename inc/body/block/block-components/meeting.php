
<!-- just copy this <section> and next script -->
            <section class="experiment">
                <section>
                    <h2 style="border: 0; padding-left: .5em;">Meeting</h2>
                    <input type="text" id="meeting-name">
                    <button id="setup-meeting">Setup New Meeting</button>
                </section>

                <table style="width: 100%;" id="meetings-list"></table>
                <table style="width: 100%;">
                    <tr id="room-list">
                        <td style="width: auto!important;">
                            <h2 style="display: block; font-size: 1em; text-align: center;">You!</h2>
                            <div id="local-streams-container"></div>
                        </td>
                        <td style="width: auto!important;">
                            <h2 style="display: block; font-size: 1em; text-align: center;">Remote Peers</h2>
                            <div id="remote-streams-container"></div>
                        </td>
                    </tr>
                </table>
            </section>
            
            <script>
                var meeting = new Meeting();
                meeting.active=false;
                var meetingsList = document.getElementById('meetings-list');
                var meetingRooms = {};

                meeting.onmeeting = function (room) {
                    if (meetingRooms[room.roomid]) return;
                    meetingRooms[room.roomid] = room;
                    meeting.active=true;
                    var tr = document.createElement('tr');
                    tr.innerHTML = '<td>' + room.roomid + '</td>' +
                        '<td><button class="join">Join</button></td>';

                    meetingsList.insertBefore(tr, meetingsList.firstChild);

                    // when someone clicks table-row; joining the relevant meeting room
                    tr.onclick = function () {
                        room = meetingRooms[room.roomid];

                        // manually joining a meeting room
                        if (room) meeting.meet(room);

                        meetingsList.style.display = 'none';
                        

                    };
                };

                var remoteMediaStreams = document.getElementById('remote-streams-container');
                var localMediaStream = document.getElementById('local-streams-container');

                // on getting media stream
                meeting.onaddstream = function (e) {
                    console.log(e);
                    if (e.type == 'local' && meeting.active == false) localMediaStream.appendChild(e.video);
                    if (e.type == 'remote' && meeting.active == true) {
                        console.log(e);
                        remoteMediaStreams.insertBefore(e.video, remoteMediaStreams.firstChild);
                    }
                };
                
                // via: https://github.com/muaz-khan/WebRTC-Experiment/tree/master/websocket-over-nodejs
                meeting.openSignalingChannel = function(onmessage) {
                    var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                    // wss://websocket-over-nodejs.herokuapp.com:443/
                    var websocket = new WebSocket('wss://webrtcweb.com:9449/');
                    websocket.onopen = function () {
                        if(meeting.active==false){
                            websocket.push(JSON.stringify({
                                open: true,
                                channel: channel
                            }));
                        }
                    };
                    websocket.push = websocket.send;
                    websocket.send = function (data) {
                        if(websocket.readyState != 1) {
                            return setTimeout(function() {
                                websocket.send(data);
                            }, 300);
                        }
                        
                        websocket.push(JSON.stringify({
                            data: data,
                            channel: channel
                        }));
                    };
                    websocket.onmessage = function(e) {
                        onmessage(JSON.parse(e.data));
                    };
                    return websocket;
                };

                // using firebase for signaling
                // meeting.firebase = 'muazkh';

                // if someone leaves; just remove his video
                meeting.onuserleft = function (userid) {
                    var video = document.getElementById(userid);
                    if (video) video.parentNode.removeChild(video);
                };

                // check pre-created meeting rooms
                meeting.check();

                document.getElementById('setup-meeting').onclick = function () {
                    // setup new meeting room
                    var meetingRoomName = document.getElementById('meeting-name').value || 'Simple Meeting';
                    meeting.setup(meetingRoomName,meeting.active);
                    
                    this.disabled = true;
                    this.parentNode.innerHTML = '<h2><a href="' + location.href + '" target="_blank">Share this link</a></h2>';
                };
            </script>



        
<article>
            <header style="text-align: center;">
                <h1>
                    WebRTC Screen Sharing
                </h1>
                <p>
                    <a href="https://www.webrtc-experiment.com/">HOME</a>
                    <span> &copy; </span>
                    <a href="http://www.MuazKhan.com/" target="_blank">Muaz Khan</a>

                    .
                    <a href="http://twitter.com/WebRTCWeb" target="_blank" title="Twitter profile for WebRTC Experiments">@WebRTCWeb</a>

                    .
                    <a href="https://github.com/muaz-khan?tab=repositories" target="_blank" title="Github Profile">Github</a>

                    .
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/issues?state=open" target="_blank">Latest issues</a>

                    .
                    <a href="https://github.com/muaz-khan/WebRTC-Experiment/commits/master" target="_blank">What's New?</a>
                </p>
            </header>

            <div class="github-stargazers"></div>

            <h2 id="number-of-participants" style="display: block;text-align: center;border:0;margin-bottom:0;">Its a full-HD (1080p) screen sharing application using <a href="https://www.webrtc-experiment.com/">WebRTC</a>!</h2>

            <!-- just copy this <section> and next script -->
            <section class="experiment">
                <section class="hide-after-join">
                    <span>
                        Private ?? <a href="/screen-sharing/" target="_blank" title="Open this link for private screen sharing!"><code><strong id="unique-token">#123456789</strong></code></a>
                    </span>
                    <input type="text" id="user-name" placeholder="Your Name">
                    <button id="share-screen" class="setup">Share Your Screen</button>
                </section>

                <!-- list of all available broadcasting rooms -->
                <table style="width: 100%;" id="rooms-list" class="hide-after-join"></table>

                <!-- local/remote videos container -->
                <div id="videos-container"></div>
            </section>

            <script>
                // Muaz Khan     - https://github.com/muaz-khan
                // MIT License   - https://www.webrtc-experiment.com/licence/
                // Documentation - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/screen-sharing

                var videosContainer = document.getElementById("videos-container") || document.body;
                var roomsList = document.getElementById('rooms-list');

                var screensharing = new Screen();

                var channel = location.href.replace(/\/|:|#|%|\.|\[|\]/g, '');
                var sender = Math.round(Math.random() * 999999999) + 999999999;

                // https://github.com/muaz-khan/WebRTC-Experiment/tree/master/socketio-over-nodejs
                var SIGNALING_SERVER = 'https://socketio-over-nodejs2.herokuapp.com:443/';
                var SIGNALING_SERVER = 'https://webrtcweb.com:9559/';
                io.connect(SIGNALING_SERVER).emit('new-channel', {
                    channel: channel,
                    sender: sender
                });

                var socket = io.connect(SIGNALING_SERVER + channel);
                socket.on('connect', function () {
                    // setup peer connection & pass socket object over the constructor!
                });

                socket.send = function (message) {
                    socket.emit('message', {
                        sender: sender,
                        data: message
                    });
                };

                screensharing.openSignalingChannel = function(callback) {
                    return socket.on('message', callback);
                };

                screensharing.onscreen = function(_screen) {
                    var alreadyExist = document.getElementById(_screen.userid);
                    if (alreadyExist) return;

                    if (typeof roomsList === 'undefined') roomsList = document.body;

                    var tr = document.createElement('tr');

                    tr.id = _screen.userid;
                    tr.innerHTML = '<td>' + _screen.userid + ' shared his screen.</td>' +
                            '<td><button class="join">View</button></td>';
                    roomsList.insertBefore(tr, roomsList.firstChild);
                    console.log("tr:"+tr);
                    var button = tr.querySelector('.join');
                    button.setAttribute('data-userid', _screen.userid);
                    button.setAttribute('data-roomid', _screen.roomid);
                    button.onclick = function() {
                        var button = this;
                        button.disabled = true;

                        var _screen = {
                            userid: button.getAttribute('data-userid'),
                            roomid: button.getAttribute('data-roomid')
                        };
                        screensharing.view(_screen);
                    };
                };

                // on getting each new screen
                screensharing.onaddstream = function(media) {
                    media.video.id = media.userid;

                    var video = media.video;
                    videosContainer.insertBefore(video, videosContainer.firstChild);
                    rotateVideo(video);

                    var hideAfterJoin = document.querySelectorAll('.hide-after-join');
                    for(var i = 0; i < hideAfterJoin.length; i++) {
                        hideAfterJoin[i].style.display = 'none';
                    }

                    if(media.type === 'local') {
                        addStreamStopListener(media.stream, function() {
                            location.reload();
                        });
                    }
                };

                // using firebase for signaling
                // screen.firebase = 'signaling';

                // if someone leaves; just remove his screen
                screensharing.onuserleft = function(userid) {
                    var video = document.getElementById(userid);
                    if (video && video.parentNode) video.parentNode.removeChild(video);

                    // location.reload();
                };

                // check pre-shared screens
                screensharing.check();

                document.getElementById('share-screen').onclick = function() {
                    var username = document.getElementById('user-name');
                    username.disabled = this.disabled = true;

                    screensharing.isModerator = true;
                    screensharing.userid = username.value;

                    screensharing.share();
                };

                function rotateVideo(video) {
                    video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(0deg)';
                    setTimeout(function() {
                        video.style[navigator.mozGetUserMedia ? 'transform' : '-webkit-transform'] = 'rotate(360deg)';
                    }, 1000);
                }

                (function() {
                    var uniqueToken = document.getElementById('unique-token');
                    if (uniqueToken)
                        if (location.hash.length > 2) uniqueToken.parentNode.parentNode.parentNode.innerHTML = '<h2 style="text-align:center; display: block"><a href="' + location.href + '" target="_blank">Right click to copy & share this private link</a></h2>';
                        else uniqueToken.innerHTML = uniqueToken.parentNode.parentNode.href = '#' + (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace( /\./g , '-');
                })();

                screensharing.onNumberOfParticipantsChnaged = function(numberOfParticipants) {
                    if(!screensharing.isModerator) return;

                    document.title = numberOfParticipants + ' users are viewing your screen!';
                    var element = document.getElementById('number-of-participants');
                    if (element) {
                        element.innerHTML = numberOfParticipants + ' users are viewing your screen!';
                    }
                };
            </script>

            <script>
                // todo: need to check exact chrome browser because opera also uses chromium framework
                var isChrome = !!navigator.webkitGetUserMedia;

                // DetectRTC.js - https://github.com/muaz-khan/WebRTC-Experiment/tree/master/DetectRTC
                // Below code is taken from RTCMultiConnection-v1.8.js (http://www.rtcmulticonnection.org/changes-log/#v1.8)
                var DetectRTC = {};

                (function () {

                    var screenCallback;

                    DetectRTC.screen = {
                        chromeMediaSource: 'screen',
                        getSourceId: function(callback) {
                            if(!callback) throw '"callback" parameter is mandatory.';
                            screenCallback = callback;
                            window.postMessage('get-sourceId', '*');
                        },
                        isChromeExtensionAvailable: function(callback) {
                            if(!callback) return;

                            if(DetectRTC.screen.chromeMediaSource == 'desktop') return callback(true);

                            // ask extension if it is available
                            window.postMessage('are-you-there', '*');

                            setTimeout(function() {
                                if(DetectRTC.screen.chromeMediaSource == 'screen') {
                                    callback(false);
                                }
                                else callback(true);
                            }, 2000);
                        },
                        onMessageCallback: function(data) {
                            if (!(typeof data == 'string' || !!data.sourceId)) return;

                            console.log('chrome message', data);

                            // "cancel" button is clicked
                            if(data == 'PermissionDeniedError') {
                                DetectRTC.screen.chromeMediaSource = 'PermissionDeniedError';
                                if(screenCallback) return screenCallback('PermissionDeniedError');
                                else throw new Error('PermissionDeniedError');
                            }

                            // extension notified his presence
                            if(data == 'rtcmulticonnection-extension-loaded') {
                                if(document.getElementById('install-button')) {
                                    document.getElementById('install-button').parentNode.innerHTML = '<strong>Great!</strong> <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Google chrome extension</a> is installed.';
                                }
                                DetectRTC.screen.chromeMediaSource = 'desktop';
                            }

                            // extension shared temp sourceId
                            if(data.sourceId) {
                                DetectRTC.screen.sourceId = data.sourceId;
                                if(screenCallback) screenCallback( DetectRTC.screen.sourceId );
                            }
                        },
                        getChromeExtensionStatus: function (callback) {
                            if (!!navigator.mozGetUserMedia) return callback('not-chrome');

                            var extensionid = 'ajhifddimkapgcifgcodmmfdlknahffk';

                            var image = document.createElement('img');
                            image.src = 'chrome-extension://' + extensionid + '/icon.png';
                            image.onload = function () {
                                DetectRTC.screen.chromeMediaSource = 'screen';
                                window.postMessage('are-you-there', '*');
                                setTimeout(function () {
                                    if (!DetectRTC.screen.notInstalled) {
                                        callback('installed-enabled');
                                    }
                                }, 2000);
                            };
                            image.onerror = function () {
                                DetectRTC.screen.notInstalled = true;
                                callback('not-installed');
                            };
                        }
                    };

                    // check if desktop-capture extension installed.
                    if(window.postMessage && isChrome) {
                        DetectRTC.screen.isChromeExtensionAvailable();
                    }
                })();

                DetectRTC.screen.getChromeExtensionStatus(function(status) {
                    if(status == 'installed-enabled') {
                        if(document.getElementById('install-button')) {
                            document.getElementById('install-button').parentNode.innerHTML = '<strong>Great!</strong> <a href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk" target="_blank">Google chrome extension</a> is installed.';
                        }
                        DetectRTC.screen.chromeMediaSource = 'desktop';
                    }
                });

                window.addEventListener('message', function (event) {
                    if (event.origin != window.location.origin) {
                        return;
                    }

                    DetectRTC.screen.onMessageCallback(event.data);
                });

                console.log('current chromeMediaSource', DetectRTC.screen.chromeMediaSource);
            </script>


            
        </article>