/**
 * Created by MMB on 14-11-2014.
 */
var config = {
    get_url: HTTP_PATH+"api.php",
    post_url: HTTP_PATH+"api.php",
    last_post: "",
    post_holder: "#posts",
    input_text: "input[name='new_text']"
};

function get_posts(){
    $.ajax({
        url: config.get_url,
        dataType: "JSON",
        cache: false,
        type: "POST",
        data: {"last_post": config.last_post},
        success:show_posts
    });
};

function show_posts(data){
  if(typeof data.posts != "undefined" && data.posts.length > 0){
      //posts returned
      $.each(data.posts,function(i,post){
          var date = new Date(post.date);
          var post_html = $([
              "<li>",
                "<span class='date'>",
                date.getHours()+":"+(date.getMinutes() > 9 ? date.getMinutes() : "0"+date.getMinutes()),
                "</span>",
                "<span class='poster'>",
                   post.poster+": ",
                "</span>",
                "<span class='text'>",
                   post.text,
                "</span>",
              "</li>"
          ].join("\n"));
          $(config.post_holder).append(post_html);
      });
  }
    if(typeof data.last_post == "string" || typeof data.last_post == "number") {
        config.last_post = data.last_post;
    }
};

function submit_post(text){
    if(text.length > 0){
        $.ajax({
            url: config.get_url,
            dataType: "JSON",
            cache: false,
            type: "POST",
            data: {"last_post": config.last_post, "new_text": text},
            success:show_posts
        });
    }

}


$(document).ready(function(){
    get_posts();

    setInterval(get_posts, 1500);

    $("#new_post").submit(function(e){
        e.preventDefault();
        var text = $(this).find(config.input_text).val();
        $(this).find(config.input_text).val("");
        if(text.length > 0){
            submit_post(text);
        }
    });
});