/**
 * Created by 闲道人阿力 on 2016/10/18.
 */

function sendmail(email,subject,body,callback) {
    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=sendmail",
        method:"post",
        data:{
            email:email,
            subject:subject,
            body:body
        },
        dataType:"json",
        success:callback

    })
}

function sendmailaliyun(email,subject,body,callback) {
    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=sendmailaliyun",
        method:"post",
        data:{
            email:email,
            subject:subject,
            body:body
        },
        dataType:"json",
        success:callback

    })
}

function saveziduan(table,a,callback) {
    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=saveziduan&table="+table+"&"+a,
        method:"get",
        dataType:"json",
        success:callback
    })



}


function sendsms(mobile,param,callback) {
    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=sendsms&mobile="+mobile+"&param="+param,
        method:"get",
        dataType:"json",
        success:callback
    })



}


function checksms(mobile,param,callback) {
    
    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=checksms&mobile="+mobile+"&code="+param,
        method:"get",
        dataType:"json",
        success:callback
    })



}
function getcode(callback) {

    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=getcode",
        method:"get",
        success:callback
    })

}

function getuid(callback) {
    $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=getuid",
        method:"get",
        success:callback
    })
}

/**
 *
 * @param cid
 * @param page
 * @param count
 * @param sourceid 源HTML模版的父ID号
 * @param targetid 将生成的Html注入到哪个标签内(ID)
 * @param noresultcallback 全部完成后的回调函数,传入当前个数
 * @param cut 字符串截取
 */

function getnextpage(cid,page,count,sourceid,targetid,noresultcallback,cut) {



    $.ajax({
            url:"/index.php?m=alicms&f=ajaxapi&v=getlists&cid="+cid+"&count="+count+"&page="+page,
            method:"get",

            dataType:"json",
            success:function (arrays) {
               // alert(JSON.stringify(arrays));

                $.each(arrays,function (e,data) {
                    var result = $("#"+sourceid).html();
                    $.each(data,function (a,b) {
                        for(var i in cut){
                            if(a==i){
                                var aaaaaa= "bbbbbbbb";
                                b=b.substring(0,cut[i]);
                            }
                        }

                        if(result.indexOf("kv."+a)>0){
                            result =result.replace("{data.kv."+a+"}",getkeyvalue(cid,a,b));
                        }
                        
                        result =result.replace("{data."+a+"}",b);


                    })
                    $("#"+targetid).append(result);
                })

                noresultcallback(arrays.length);
            }

        })


}



function pages(obj,callback) {

    var x = "&cid="+obj.cid;
     x += "&page="+obj.page;
     x += "&where="+obj.where;
     x += "&count="+obj.count;
     x += "&order="+obj.order;
     x += "&urlrule="+obj.urlrule;


    $.ajax({
        url:"/index.php?m=alicms&f=apijs&v=pages",
        method:"post",
        data:{
            cid:obj.cid,
            page:obj.page,
            where:obj.where,
            count:obj.count,
            order:obj.order,
            urlrule:obj.urlrule,
            pagelimit:obj.pagelimit,



        },
        success:callback
    })



}

function alipages(obj,callback) {
    pages(obj,callback);
}


function aliismobile(mobile) {
    var reg = /^(((1[0-9]{2}))+\d{8})$/ ;
    return reg.test(mobile);
}
function aliisidcard(idcard) {
    var reg = /^\d{17}(\d|X|x)$/;
    return reg.test(idcard);
}

function aliisemail(email) {
    var reg = /\w+[@]{1}\w+[.]\w+/;
    return reg.test(email);
}


function getkeyvalue(cid,ziduan,value) {

    var html = $.ajax({
        url:"/index.php?m=alicms&f=ajaxapi&v=getkeyvalue&cid="+cid+"&ziduan="+ziduan+"&value="+value,
        async: false
    }).responseText;

    return html;

}