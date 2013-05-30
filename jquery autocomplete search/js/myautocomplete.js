function getKeywords(type, block) {
				
				var keyword = $(block).val();
				var availableTags = new Array();
				$.ajax({                                      
					url: 'processData.php', 
					type: 'GET',                       
					contentType: 'text/html',
					dataType: 'text',
					cache: true,
					data: {
						type: type,
						keyword: keyword
					},
					success: function(msg)
					{
						$("#noData").val("Match");
						availableTags = JSON.parse(msg);
						if(availableTags == 'NoMatch')
						{
							$("#noData").val("noMatch");
						}
					},
					error: function (msg) 
					{
					}
				});
		  
				$(block)
					// don't navigate away from the field on tab when selecting an item
					.bind( "keydown", function( event ) {
						if ( event.keyCode === $.ui.keyCode.TAB &&
							$( this ).data( "autocomplete" ).menu.active ) {
							event.preventDefault();
						}
					})
					
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							// delegate back to autocomplete, but extract the last term
							if(availableTags != 'NoMatch')
							{
								response( $.ui.autocomplete.filter(
									availableTags, extractLast( request.term ) ) );
							}
							else
							{
								response( $('.ui-autocomplete').val('Add "'+request.term+'" as your skill'));
								//$("#keywordUsed").val(request.term);
							}
							//alert(availableTags);
						},
						focus: function() {
							return false;
						},
						select: function( event, ui ) {
							var terms = split( this.value );
							// remove the current input
							terms.pop();
							// add the selected item
							terms.push( ui.item.value );
							// add placeholder to get the comma-and-space at the end
							terms.push( "" );
							this.value = terms.join( "" );
							var noData = $('#noData').val();
							if(noData == 'noMatch'){
								var n = this.value;
								var n = n.split('"');
								this.value = n[1];
							}
							if($('.chosenKeyword').is('#'+this.value+'')){
								//do nothing
							}
							else{
								$('#autocompleteGrid')
									.append('<span id='+this.value+' class="chosenKeyword">'+this.value+
									'<span class="hideButton" onclick="hideData(this)">[X]</span></span>');
							}
							var keywordused = $('#keyValue').val();
							$('#keyValue').val("");
							// call to function searchedKeyword() to store 
							// the searched keywords in database
							//var noData = $('#noData').val();
							if(noData == 'noMatch') {
								storeUnmatchKeywords(keywordused);
							}
							else{
								searchedKeyword(keywordused);
							}
							return false;
						}
					});
					
					function split( val ) {
						return val.split( /,\s*/ );
					}
					
					function extractLast( term ) {
						return split( term ).pop();
					}

			}
			function hideData(x)
			{
				$('#keyValue').val("");
				$(x).parent('span').remove();
				//$('#nextBox').css('display','none');
			}
			
			function storeUnmatchKeywords(keywordFilled)
			{
				var keyword = keywordFilled;
				var userId = $("#userId").val();
				var keywordType = $("#keywordType").val();
				$.ajax({                                      
					url: 'processData.php', 
					type: 'GET',                       
					contentType: 'text/html',
					dataType: 'text',
					cache: true,
					data: {
						reqType: 'newKeyword',
						keyword: keyword,
						keywordType : keywordType,
						userId : userId
					},
					success: function(msg)
					{
						//do any function you like
					},
					error: function (msg) 
					{
					}
				}); 
			}
			
			function searchedKeyword(keywordFilled)
			{
				var keyword = keywordFilled;
				var userId = $("#userId").val();
				var keywordType = $("#keywordType").val();
				$.ajax({                                      
					url: 'processData.php', 
					type: 'GET',                       
					contentType: 'text/html',
					dataType: 'text',
					cache: true,
					data: {
						reqType: 'storeKeyword',
						keyword: keyword,
						keywordType : keywordType,
						userId : userId
					},
					success: function(msg)
					{
						
					},
					error: function (msg) 
					{
					}
				});
			}