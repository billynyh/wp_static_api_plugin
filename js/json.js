jQuery(function($){
  $(document).ready(function(){
    var ele = $("textarea.wp-editor-area");
    var viewer = $("#json_viewer_box .container");

    function syncJsonViewer(){
      var obj = JSON.parse(ele.val());
      var str = JSON.stringify(obj, null, 4);
      viewer.html(str);
    }

    syncJsonViewer();
    ele.change(function(){
        syncJsonViewer();
    })
  });

});
