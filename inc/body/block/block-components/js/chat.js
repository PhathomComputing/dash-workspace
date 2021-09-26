$('.chat-box').append('<div id="box-messages" class="box-messages" style="word-wrap: break-word;"></div>');
                            
                            var name="";
                            function getChat(){
                                // console.log("retrieve");
                                jQuery.ajax({
									url:"inc/body/block/block-components/blockDBcom.php",
									method:"post",
									data:{'block-data':{'mode':'retrieve'}},
									success: function(msgs){
										processChat(msgs);
										//// console.log(container);
									},
									error: function(){
										// console.log('failure');
									},
								});
                            }
						
							// window.setInterval(function() {
							// 	getChat();
							// 	// console.log("repeating...");
							// 	$(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);
							//   }, 1000);

							function processChat(msgs){
								console.log(JSON.parse(JSON.parse(msgs)['query']['data']));
										messages = JSON.parse(JSON.parse(msgs)['query']['data']);
										var container = '';
										for(var i=0; i<messages.length;i++){
											var user = messages[i].user;
											var msg = messages[i].msg;
											if(user == name){
												container += '<div class="row"><span style= "float: right;margin-left: 20px;background-color: cadetblue;padding: 5px;border-radius: 5px;" class="msg msg-user msg-'+user+'">'+msg+'</span></div>';
											} else {
												container += '<div class="row"><span style= "float: left;margin-left: 20px;background-color: lightgrey;padding: 5px;border-radius: 5px;" class="msg msg-guest msg-'+user+'">'+msg+'</span></div>';
											}
											
										}
										if( i == messages.length-1){
											container += '<span class="bottom-msgs"></span>';

										}
										$('.chat-box').html(container);
										$('.bottom-msgs').focus();
							}

							function bottomScroll(elClass){
								var element = document.getElementsByClassName(elClass)[0].scrollTop;
								element.scrollTop = element.scrollHeight;
							}

                            function loadChat(data){

                            }
                            $('.chat-input').keypress( function(key){
                                if(key.which == 13){
                                    onClick();
                                }    

                            });
							
							function onClick(){
                                if(name=="") {
									getUserName();
									// setInterval(getChat(),500);
									
								}
								getMessage();
								// chatSnapshot();
								clearInput();
								
								getChat();
								$(".chat-box").scrollTop($(".chat-box")[0].scrollHeight);

								

							}
                            
                            function clearInput(){
                                $('.chat-input').val('');
                            }

                            function getUserName(){
								name = window.prompt("What is your username?");
								getChat();
                            }

							function chatSnapshot(){
								var dtToday = new Date().toISOString().slice(0, 19).replace('T', ' ');
                                var container = $('.box-messages').contents();
                                var messages=[];
                                for(var i=0; i<container.length;i++){
									var user = (container[i].childNodes[0].className).split(' ')[2];
									user = user.split('-')[1];
                                    var msg = container[i].innerText;
									messages.push({ user : user , msg : msg , date : dtToday});
                                }
                                // console.log(messages);
								

								contents=JSON.stringify(messages);
								var senddata ={'block-data':{'mode':'synch','log':contents}};
								// console.log(senddata);
								jQuery.ajax({
									url:"inc/body/block/block-components/blockDBcom.php",
									method:"post",
									data:senddata,
									success: function(){
										// console.log('success');
								},
									error: function(){
										// console.log('failure');
								},
								});
								
								
								// console.log("finish");
							}
							function getMessage(){
								var input= $('.chat-input').val();
								msg = addMessage('user-'+name,input);
								upMsg(name,input);
								// console.log(input);
							}

							function upMsg(name,msg){
								var dtToday = new Date().toISOString().slice(0, 19).replace('T', ' ');
								var contents =  JSON.stringify({ user:name, msg:msg , date: dtToday});
								var senddata ={'block-data':{'mode':'synch','log':contents}};
								// console.log(senddata);
								jQuery.ajax({
									url:"inc/body/block/block-components/blockDBcom.php",
									method:"post",
									data:senddata,
									success: function(){
										// console.log('success');
								},
									error: function(){
										// console.log('failure');
								},
								});

							}

							function addMessage(who,what){
								var msg = '<div class="row"><span class="msg msg-user '+who+'">'+what+'</span></div>';
								$('.box-messages').append(msg);
								return msg;
							}