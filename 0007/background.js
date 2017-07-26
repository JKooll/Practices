function getImg(tab)
{
    var inject_details = {
        code : "console.log('inject success!!!')",
        allFrames : true
    }

    chrome.tabs.executeScript(tab.id, inject_details, function(result) {
        alert(result);
    });
}

chrome.browserAction.onClicked.addListener(function(tab){
    getImg(tab);
});
