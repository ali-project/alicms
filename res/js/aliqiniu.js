function qiniuinit(browse_button,ismulti,addcallback,okcallback,errcallback,extensions) {

    var uploader = Qiniu.uploader({
        runtimes: 'html5',    //上传模式,依次退化
        browse_button: browse_button,       //上传选择的点选按钮，**必需**
        //uptoken_url: 'upload1.html',            //Ajax请求upToken的Url，**强烈建议设置**（服务端提供）
        uptoken : '<?php echo $token; ?>', //若未指定uptoken_url,则必须指定 uptoken ,uptoken由其他程序生成
        // unique_names: true, // 默认 false，key为文件名。若开启该选项，SDK为自动生成上传成功后的key（文件名）。
        // save_key: true,   // 默认 false。若在服务端生成uptoken的上传策略中指定了 `sava_key`，则开启，SDK会忽略对key的处理
        domain: 'http://qiniu-plupload.qiniudn.com/',   //bucket 域名，下载资源时用到，**必需**
        container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
        max_file_size: '100mb',           //最大文件体积限制
        flash_swf_url: '',  //引入flash,相对路径
        max_retries: 3,                   //上传失败最大重试次数
        dragdrop: false,                   //开启可拖曳上传
        drop_element: 'container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
        chunk_size: '4mb',                //分块上传时，每片的体积
        auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
        multi_selection: ismulti,
        filters : {
            max_file_size : '100mb',
            prevent_duplicates: true,
            // Specify what files to browse for
            mime_types: [
                {title : "Image files", extensions : extensions}, // 限定jpg,gif,png后缀上传
            ]
        },




        init: {
            'FilesAdded': addcallback,
            'BeforeUpload': function(up, file) {
                // 每个文件上传前,处理相关的事情
            },
            'UploadProgress': function(up, file) {
                // 每个文件上传时,处理相关的事情
            },
            'FileUploaded': okcallback,
            'Error': errcallback,
            'UploadComplete': function() {
                //队列文件处理完毕后,处理相关的事情
            },
            'Key': function(up, file) {
                // 若想在前端对每个文件的key进行个性化处理，可以配置该函数
                // 该配置必须要在 unique_names: false , save_key: false 时才生效
                var date = new Date();
                var Y = date.getFullYear() + '';
                var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '';
                var D = date.getDate() + '';
                var h = date.getHours() + '';
                var m =(date.getMinutes()+1 < 10 ? '0'+(date.getMinutes()+1) : date.getMinutes()+1) + '';// date.getMinutes() + '';
                var s = date.getSeconds();
                var r = parseInt(1000000*Math.random()+1000000);
                var houzui = file.name.split(".");
                var houzui2 = houzui[houzui.length-1];
                var key =Y+M+D+h+m+s+r+"."+houzui2;


                // do something with key here
                return key;
            }
        }
    });

    return uploader;


}
