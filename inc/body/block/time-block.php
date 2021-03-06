
<?=smBlockStart();?>
    <?=setTitle('Local Time');?>
    <hr>
    <div class="clockcenter">
        <script>
            var jun = moment("2014-06-01T12:00:00Z");
            console.log(jun.tz('America/Los_Angeles').format('ha z'));
        </script>
        <digiclock>12:45:25</digiclock>
    </div>

<?=smBlockMid();?>
            <?=setTitle('File Browser');?>
                <hr>
                <!-- Button trigger modal -->
            <button type="button" class="btn launch-button" data-toggle="modal" data-target="#browserModal">
            Launch
            </button>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <!-- Modal -->
                    <div class="modal fade " id="browserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Browser</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                
                                <script data-main="assets/elfinder/main.js" src="assets/js/require.min.js"></script>
                                <script>
                                    define('elFinderConfig', {
                                        // elFinder options (REQUIRED)
                                        // Documentation for client options:
                                        // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
                                        defaultOpts : {
                                            url : 'assets/elfinder/php/connector.minimal.php' // connector URL (REQUIRED)
                                            ,commandsOptions : {
                                                edit : {
                                                    extraOptions : {
                                                        // set API key to enable Creative Cloud image editor
                                                        // see https://console.adobe.io/
                                                        creativeCloudApiKey : '',
                                                        // browsing manager URL for CKEditor, TinyMCE
                                                        // uses self location with the empty value
                                                        managerUrl : ''
                                                    }
                                                }
                                                ,quicklook : {
                                                    // to enable CAD-Files and 3D-Models preview with sharecad.org
                                                    sharecadMimes : ['image/vnd.dwg', 'image/vnd.dxf', 'model/vnd.dwf', 'application/vnd.hp-hpgl', 'application/plt', 'application/step', 'model/iges', 'application/vnd.ms-pki.stl', 'application/sat', 'image/cgm', 'application/x-msmetafile'],
                                                    // to enable preview with Google Docs Viewer
                                                    googleDocsMimes : ['application/pdf', 'image/tiff', 'application/vnd.ms-office', 'application/msword', 'application/vnd.ms-word', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/postscript', 'application/rtf'],
                                                    // to enable preview with Microsoft Office Online Viewer
                                                    // these MIME types override "googleDocsMimes"
                                                    officeOnlineMimes : ['application/vnd.ms-office', 'application/msword', 'application/vnd.ms-word', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.presentation']
                                                }
                                            }
                                            // bootCalback calls at before elFinder boot up 
                                            ,bootCallback : function(fm, extraObj) {
                                                /* any bind functions etc. */
                                                fm.bind('init', function() {
                                                    // any your code
                                                });
                                                // for example set document.title dynamically.
                                                var title = document.title;
                                                fm.bind('open', function() {
                                                    var path = '',
                                                        cwd  = fm.cwd();
                                                    if (cwd) {
                                                        path = fm.path(cwd.hash) || null;
                                                    }
                                                    document.title = path? path + ':' + title : title;
                                                }).bind('destroy', function() {
                                                    document.title = title;
                                                });
                                            }
                                        },
                                        managers : {
                                            // 'DOM Element ID': { /* elFinder options of this DOM Element */ }
                                            'elfinder': {}
                                        }
                                    });
                                </script>
                                        <div id="elfinder"></div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?=blockEnd();?>