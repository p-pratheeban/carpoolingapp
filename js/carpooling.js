$(function() {

	//Get all posts
    $("a#getposts").click(function(event) {
		getTripPosts();
	});
    //Get all Favorites
    $("a#getfavorites").click(function(event) {
		getFavoritePosts();
	});    
	//Get trip posts by keyword
	$("button#searchbtn").click(function(event) {
		serchTripPost();
	});
    $("a#getHome").click(function(event) {
        getPostComments();
        setTimeout(function(){
        postComments("", "");
        }, 500);
    });
    //Display posts with comments
    $.get('display-trip.php')
    .done(displayPostSuccess)
    .fail(displayPostFailure); 
    getUserComments();
    setTimeout(function(){
    postComments("", "");
    }, 500);
    //Remove trip post
    remove();

    $('body').on('click', '.status-edit', function () {

        $(this).hide();
        var $parent = $(this).parents('.status');
        var status = $parent.find('.p-status').text();
        $parent.find('.p-status').html('<input class="input-status" type="text" value="' + status + '" size="124">');

        return false;
    });

    $('body').on('keypress', '.input-status', function (event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode === 13) {
            var $parent = $(this).parents('.status');
            var status = $(this).val();
            var status_id = $parent.find('.status-id').val();
            $(this).remove();

            $parent.find('.status-edit').show();
            $parent.find('.p-status').html(status);

            $.ajax({
                url: "update-trip.php",
                type: "POST",
                data: {'status': status, 'status_id': status_id},
                dataType: "JSON",
                success: function () {

                }, error: function () {
                    alert('Error in updating status.');
                }
            });
        }
    });   
    
    
	$('#btnPostTrip').click(function() {
		var postTripText = $('#txtBoxPostTrip').val();
        
		$.post('post-trip.php', {'postTripText': postTripText})
			.done(postSuccess)
			.fail(postFailure);
	});   
    
});

//Remove trip post
function remove() {    

    $('body').on('click', '.deletedpost', function (event) {
        var removeid = $(this).attr('remove');
        $('#div_' + removeid).hide();

        $.ajax({
            'url': 'delete-trip.php',
            'type': 'POST',
            data: {
                source11: removeid
            },
            'success': ajaxInsertDeleted,
            'error': ajaxFailure

        });
    });
}
function ajaxInsertDeleted(data) {
    
}
//Get posts with comments
function getPostComments(){
    $("#postText").empty();
    $.get('display-trip.php')
    .done(displayPostSuccess)
    .fail(displayPostFailure);
}  
function displayPostSuccess(data) {
    for (var i = 0; i < data.length; i++) {
        
        var id = data[i].trip_id;
        var status = data[i].trip_text;
        var user_id = data[i].user_id;
        var user_name = data[i].username;
        var created_date = data[i].created_date
        
       var editpost = "";
       var username = $(".user").text();
       
        if (username == user_name) {
            
            editpost += "<span class='deletedpost right' remove='" + id + "'><a  title='Delete'><img src='../images/delete.gif'></a></span> <span class='status-edit right'> <a href='#' title='Edit'> <img src='../images/edit.gif'> </a> </span>";

        }
        
        var postcomm = "<div class='status well padding margin' id='div_" + id + "'> <span class='user_name'><strong>" + user_name + "</strong></span> <span class='created_date'><strong>" + created_date + "</strong></span>" + editpost + "<p class='p-status'> " +
                status + "</p> ";

        postcomm += '<input type="hidden" value="' + id + '" class="status-id">';
        
        postcomm += "<div class='newcomment' id='cmt_" + id +
                "'></div> ";
        postcomm += "<div><input type='text' inputid='" +
                id + "' class='commentbox' Placeholder='Comment Here' size='124'/> </div></div>";

     
        $('#postText').append(postcomm);
	}
   
}

function displayPostFailure() {
	$('#errors').text('An ajax error occurred.');
}




function postSuccess(data) {
    $('#txtBoxPostTrip').val('');
    var txtBoxPost = $('<div class="status well"><textarea>')
			.text(data.trip_text);
    $('#postText').prepend(txtBoxPost);  
}

function postFailure() {
	$('#errors').text('An ajax error occurred.');
}


function getUserComments() {
   
    $('body').on('keypress', '.commentbox', function (event) {
       
       
        var keycode = (event.keyCode ? event.keyCode : event.which);
       
        if (keycode === 13) {

            var cmt1 = $(this).val();
            var idcomment = $(this).attr('inputid');

            postComments(cmt1, idcomment);

            $(this).val(" ");
           
            var par = $(this).parents('.status').find('.newcomment');
            $('<p>').text(cmt1).attr("id", "").appendTo(par);
           
        }

    });
}

function postComments(cmt1, idcomment) {
    
    $.ajax({
        cache : false,
        'url': 'post-comments.php',
        'type': 'POST',
        data: {
            source1: cmt1,
            source2: idcomment
        },
        'success': ajaxSuccesscomment,
        'error': ajaxFailure

    });
}

function ajaxSuccesscomment(data) {
    
    var myData2 = jQuery.parseJSON(data);
    $('.newcomment').html("");
    for (var i = 0; i < myData2.length; i++) {
        var comid = myData2[i].comment_id;
        var comment = myData2[i].comment_text;
        var tripid = myData2[i].trip_id;
        var userid = myData2[i].user_id;
        
        $('#cmt_' + tripid).append("<p class='commentimp' >" + comment + "<a class='right' onclick='deleteComment(this)'><img src='../images/delete.gif'></a></p>");
    }

}

function ajaxFailure(xhr, status, exception) {
    
    console.log(xhr, status, exception);
}
//Delete Comment
function deleteComment(ele){
    var parentelem = $(ele).parent();
    var comment = $(parentelem).text();
    parentelem.hide();
    deleteComments(comment);

}
//Delete Favorite post
function deleteComments(commenttext) {

    $.ajax({
        url: "deletecomment.php",
        type: "POST",
        data: {'comment':commenttext},
        success: successDeleteComment,
        error: errorDeleteComment,
        complete: function( xhr, status ) {
        console.log("The request is complete!");
    }
    });
}


function successDeleteComment(result) {
    
}
function errorDeleteComment(xhr, status, strErr) {
    console.log("There was an error!");

}
//display post with favorite
function displayPostFavorite(username,createdate,triptext,favourite){
    var ele = "<div class='row oldpost'>"+
               "<div class='col-lg-9'><button class="+favourite+" onclick='tooggleFavourite(this)'></button><strong>"+username+"</strong></div><div class='col-lg-3'><strong>"+createdate+"</strong></div>"+
               "<div class='col-lg-12'><textarea class='trippost' cols='120' disabled>"+triptext+"</textarea></div></div>";
    return ele;

}

function tooggleFavourite(ele){
    var trippost = $(ele).parents(".oldpost").find('.trippost').val();
    if($(ele).hasClass('fav')){
        $(ele).removeClass('fav');
        $(ele).addClass('fav1');    
        insertFavoritePost(trippost);
    }
    else{
        $(ele).removeClass('fav1');
        $(ele).addClass('fav');
        deleteFavoritePost(trippost);
    } 
}
// Insert Favorite Post
function insertFavoritePost(triptext) {

	$.ajax({
		url: "insertfavourite.php",
		type: "POST",
		data: {'trippost':triptext},
		success: successInsertFavorite,
		error: errorInsertFavorite,
		complete: function( xhr, status ) {
		console.log("The request is complete!");
	}
	});
}


function successInsertFavorite(result) {
	
}
function errorInsertFavorite(xhr, status, strErr) {
	console.log("There was an error!");

}
//Delete Favorite post
function deleteFavoritePost(triptext) {

    $.ajax({
        url: "deletefavourite.php",
        type: "POST",
        data: {'trippost':triptext},
        success: successDeleteFavorite,
        error: errorDeleteFavorite,
        complete: function( xhr, status ) {
        console.log("The request is complete!");
    }
    });
}


function successDeleteFavorite(result) {
    
}
function errorDeleteFavorite(xhr, status, strErr) {
    console.log("There was an error!");

}
// Get last newest 20 trip posts
function displayPost(username,createdate,triptext){
	var ele = "<div class='row oldpost'><div class='col-lg-9'><strong>"+username+"</strong></div>"+
	 		"<div class='col-lg-3'><strong>"+createdate+"</strong></div>"+
	 		"<div class='col-lg-12'><textarea cols='120' disabled>"+triptext+"</textarea></div></div>";
	return ele;

}
function getTripPosts() {
	$.ajax({
		url: "gettrippost.php",
		type: "GET",
		success: successPosts,
		error: errorPosts,
		complete: function( xhr, status ) {
		console.log("The request is complete!");
	}
	});
}


function successPosts(result) {
	console.log("Getting result");
    var favourite;
	$("#postText").empty();

	$.each(result, function(i, obj) {
        var favid = obj.favorite_id;
        if(obj.favorite_id == null){
            favourite = "fav";
        }
        else{
            favourite ="fav1";
        }
        console.log(typeof obj.favorite_id+"-"+favid+"-"+favourite);
	 	var ele= displayPostFavorite(obj.username,obj.created_date,obj.trip_text,favourite);
 		$(ele).appendTo('#postText');
 		if(i==20){
 			return false;
 		}
	});
}
function errorPosts(xhr, status, strErr) {
	console.log("There was an error!");

}
//Get all favourite trip posts
function getFavoritePosts() {
	$.ajax({
		url: "getfavoritespost.php",
		type: "GET",
		success: successFavorites,
		error: errorFavorites,
		complete: function( xhr, status ) {
		console.log("The request is complete!");
	}
	});
}

function successFavorites(result) {
	console.log("Getting result");
	$("#postText").empty();
	$.each(result, function(i, obj) {
	 	var ele= displayPost(obj.username,obj.created_date,obj.trip_text);
 		$(ele).appendTo('#postText');
	});
}
function errorFavorites(xhr, status, strErr) {
	console.log("There was an error!");

}
//Get trip posts by keword
function serchTripPost() {
	var keywordVal = $("#keyword").val();
	$.ajax({
		url: "serchtrippost.php",
		data: {'keyword':keywordVal},
		type: "GET",
		success: successSearch,
		error: errorSearch,
		complete: function( xhr, status ) {
		console.log("The request is complete!");
	}
	});
}

function successSearch(result) {
	console.log("Getting result");

	$("#postText").empty();
	$.each(result, function(i, obj) {
	 	var ele= displayPost(obj.username,obj.created_date,obj.trip_text);
 		$(ele).appendTo('#postText');
	});
}
function errorSearch(xhr, status, strErr) {
	console.log("There was an error!");

}
