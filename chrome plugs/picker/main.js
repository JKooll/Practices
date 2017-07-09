$(function(){
    $("#result").hide();

    $("#current_tab").bind("click", function() {
        getImage(getCurrentTabImage);
    });

    $("#all_tab").bind("click", function() {
        getImage(getAllTabImage);
    });

    var renderImage = function(urls) {
        $("#status").text("Rendering...");
        var _url = undefined;
        if ((_url = urls.pop()) == undefined) {
            $("#status").text("完成^_^");
            downloadHandle();
            $("#result").show();
            return;
        }
        //检查是否为http或https连接
        var regexp = /^(http|https):\/\/.*/i;
        if(!checkUrl(_url, regexp)) {
            renderImage(urls);
        } else {
            $("<base/>", {href : _url}).prependTo("head");
            $.ajax({
                url: _url,
                success: function(data) {
                    $("#result").attr("hidden", false);
                    let images = $(data).find('img');
                    let imagesList = [];
                    $.each(images, function(i, el) {
                        imagesList[i] = el.src;
                        $('<div class="col-xs-6 col-md-3 image_item"><a href="#" class="thumbnail"><img src="'+ el.src + '" alt="..." style="height: 121px; width: 121px; display: block;"></a><button class="btn btn-success btn-xs download_button">Download</button></div>')
                        .appendTo("#result");
                    });
                    $("#status").text($("#status").text() + imagesList.length + "\n");
                    renderImage(urls);
                },
                error: function(data) {}
            });
        }
    }

    var clearResultArea = function() {
        $("#result").children().remove();
    }

    //设置download button事件
    var downloadHandle = function() {
        $(".image_item").hover(function() {
            $(this).find(".download_button").show();
        }, function() {
            $(this).find(".download_button").hide();
        });
        $(".download_button").bind("click", function (){
            let a_object = $(this).parent().find('a');
            a_object.attr('download', "");
            let image_src = $(this).parent().find('img').attr('src');
            a_object.attr('href', image_src);
            a_object[0].click();
            // a_object.attr('href', '#');
            // a_object.removeAttr('download');
        }).hide();
    }

    var checkUrl = function(url, regexp) {
        if(url.match(regexp) == null || url.match(regexp)[0] != url) {
            return false;
        }
        return true;
    }

    var getCurrentTabImage = function(url) {
        renderImage(url);
    }

    var getAllTabImage = function(urls) {
        renderImage(urls);
    }

    var getImage = function(callback) {
        $("#status").text("Rendering...");
        getTabUrl(callback);
    }

    function getTabUrl(callback) {
        var queryInfo = {
          currentWindow: true
        };

        if(callback == getCurrentTabImage) {
            queryInfo = {
                active : true,
                currentWindow : true
            }
        }

        chrome.tabs.query(queryInfo, function(tabs) {
          var urls = [];
          for(index in tabs) {
              urls.push(tabs[index].url);
          }
          clearResultArea();
          callback(urls);
      });
  }
});
