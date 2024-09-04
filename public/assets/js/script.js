function base_url(url){
    let base_url = "files.ariestech.cloud/public/";
    return base_url+url;
}
$(document).ready(function() {
  $('#dataTable').DataTable();
});
$('#checkin').change(function() {
    // this will contain a reference to the checkbox   
    if($(this).is(":checked")){
        $(".checkin i").attr("class","fas fa-minus-square fa-fw");
        $(".input-check").prop("checked",true);
    }else{
        $(".checkin i").attr("class","fas fa-check-square fa-fw");
        $(".input-check").prop("checked",false);
    }
});


$(".btn-action").click(function(){
    let action = $(this).attr("data-action");
    switch(action) {
  case "add":
add();
    break;
    case "rename":
rename($(this));
    break;
    case "del":
del($(this));
    break;
    case "copy":
copy($(this));
    break;
    case "move":
move($(this));
    break;
    case "del_checked":
del_checked($(this));
    break;
case "copy_checked":
copy_checked($(this));
    break;
case "move_checked":
move_checked($(this));
    break;
    case "upload":
upload($(this));
    break;
case "unzip":
unzip($(this));
    break;
    case "download":
download($(this));
    break;
  default:
    // code block
}
});


    