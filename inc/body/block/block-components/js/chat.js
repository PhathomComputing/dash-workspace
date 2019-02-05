$('.chat-box').append('<div class="box-messages"></div>');
                            
                            var name="";
                            (function(){
                                console.log("retrieve");
                                jQuery.ajax({
									url:"inc/body/block/block-components/blockDBcom.php",
									method:"post",
									data:{'block-data':{'mode':'retrieve'}},
									success: function(msgs){console.log(JSON.parse(msgs));},
									error: function(){console.log('failure');},
								});
                            }());

                            function loadChat(data){

                            }
                            $('.chat-input').keypress( function(key){
                                if(key.which == 13){
                                    onClick();
                                }    

                            });

							function onClick(){
                                if(name=="") getUserName();
								getMessage();
                                chatSnapshot();
                                clearInput();
							}
                            
                            function clearInput(){
                                $('.chat-input').val('');
                            }

                            function getUserName(){
                                name = window.prompt("What is your username?");
                            }

							function chatSnapshot(){
								console.log($('.box-messages').contents());
                                var container = $('.box-messages').contents();
                                var messages=[];
                                for(var i=0; i<container.length;i++){
                                    var user = (container[i].childNodes[0].className).split(' ')[2];
                                    var msg = container[i].innerText;
                                    messages.push({ user : user , msg : msg });
                                }
                                console.log(messages);
								

								contents=JSON.stringify(messages);
								var senddata ={'block-data':{'mode':'synch','log':contents}};
								console.log(senddata);
								console.log("start");
								jQuery.ajax({
									url:"inc/body/block/block-components/blockDBcom.php",
									method:"post",
									data:senddata,
									success: function(){console.log('success');},
									error: function(){console.log('failure');},
								});
								
								
								console.log("finish");
							}
							function getMessage(){
								var input= $('.chat-input').val();
								addMessage('user-'+name,input);
								console.log(input);
							}

							function addMessage(who,what){
								var msg = '<div class="row"><span class="msg msg-user '+who+'">'+what+'</span></div>';
								$('.box-messages').append(msg);
								console.log(msg);
							}