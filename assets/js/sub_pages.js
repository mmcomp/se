function change_page_sub()
{
    var page = $("#page").val();
    var tmp = (String(page)==="1")?"":"/"+page;
    window.location = site_url+( (typeof tag_addr==='undefined')?tmp:'/'+tag_addr+tmp);
}