function base_url(url = ""){
    let base = "http://files.ariestech.cloud/public/";
    return base+url;
}
function add(){
    $("#ModalLabel").html("New Item");
    let path_dir = $("#path_dir").val();
    let html = `        <div class="btn-group">
<input type="radio" class="btn-check" name="type_item" id="folder" autocomplete="off" value="folder" checked>
<label class="btn btn-outline-primary" for="folder">Folder</label>
<input type="radio" class="btn-check" name="type_item" id="file" autocomplete="off" value="file">
<label class="btn btn-outline-primary" for="file">File</label>
</div>
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="text" class="form-control" name="item" autocomplete="off" autofocus placeholder="Name item">
</div>`;
    $(".modal-body").html(html);
   $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="add">Save changes</button>
        `);  
}

function rename(i){
    $("#ModalLabel").html("Rename Item");
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="from" value="`+item+`">
    <input type="text" class="form-control" name="item" autocomplete="off" placeholder="Name item" autofocus value="`+item+`">
</div>`;
    $(".modal-body").html(html);
    $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="rename">Save changes</button>
        `);
}
function del(i){
    $("#ModalLabel").html("Delete Item");
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="item" value="`+item+`">
    <p>Are you sure you want to delete this item?</p>
</div>`;
    $(".modal-body").html(html);
   $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="del">Save changes</button>
        `);;
}
function del_checked(i){
    let path_dir = $("#path_dir").val();
    $("#ModalLabel").html("Delete Item");
    let val = [];
    $('.input-check:checked').each(function(i){
          val[i] = $(this).val();
        });
    if(val.length > 0){
        let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="items" value="`+val+`">
    <p>Are you sure you want to delete this item?</p>
</div>`;
        $(".modal-body").html(html);
        $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="del_checked">Save changes</button>
        `);
    }else{
        $(".modal-body").html("<p>Please select an item</p>");
        $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        `);
    }
}
function copy(i){
    $("#ModalLabel").html("Copy Item");
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    let hash = encodeURIComponent(btoa(path_dir));
    let se = base_url("Home/Ajax/"+hash);
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="item" value="`+item+`">
    <p>Select target folder </p>
</div>
<div class="modal-container"></div>
`;
    $(".modal-body").html(html);
    $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="copy">Save changes</button>
        `);
    send(se,$(".modal-body .modal-container"));
      
}
function move(i){
    $("#ModalLabel").html("Move Item");
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    let hash = encodeURIComponent(btoa(path_dir));
    let se = base_url("Home/Ajax/"+hash);
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="item" value="`+item+`">
    <p>Select target folder </p>
</div>
<div class="modal-container"></div>
`;
    $(".modal-body").html(html);
    $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="move">Save changes</button>
        `);
    send(se,$(".modal-body .modal-container"));
      
}

function copy_checked(i){
    $("#ModalLabel").html("Copy Item");
    let path_dir = $("#path_dir").val();
    let hash = encodeURIComponent(btoa(path_dir));
    let se = base_url("Home/Ajax/"+hash);
    let val = [];
    $('.input-check:checked').each(function(i){
          val[i] = $(this).val();
        });
    
    if(val.length < 1){
        
        $(".modal-body").html("<p>Please select an item</p>");
        $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        `);
    }else{
        let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="items" value="`+val+`">
    <p>Select target folder </p>
</div>
<div class="modal-container"></div>
`;
        $(".modal-body").html(html);
        $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="copy_checked">Save changes</button>
        `);
        send(se,$(".modal-body .modal-container"));
    }
}
function move_checked(i){
    $("#ModalLabel").html("Move Item");
    let path_dir = $("#path_dir").val();
    let hash = encodeURIComponent(btoa(path_dir));
    let se = base_url("Home/Ajax/"+hash);
    let val = [];
    $('.input-check:checked').each(function(i){
          val[i] = $(this).val();
        });
    
    if(val.length < 1){
        
        $(".modal-body").html("<p>Please select an item</p>");
        $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        `);
    }else{
        let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="items" value="`+val+`">
    <p>Select target folder </p>
</div>
<div class="modal-container"></div>
`;
        $(".modal-body").html(html);
        $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="move_checked">Save changes</button>
        `);
        send(se,$(".modal-body .modal-container"));
    }
}
function upload(i){
    $("#ModalLabel").html("Upload Item");
    
    let path_dir = $("#path_dir").val();
    
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">

  <label for="formFileMultiple" class="form-label">Select the file you want to upload</label>
  <input class="form-control" type="file" id="formFileMultiple" multiple name="files[]">

</div>`;
    $(".modal-body").html(html);
    $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="upload">Save changes</button>
        `);;
}
function unzip(i){
    $("#ModalLabel").html("Unzip Item");
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="item" value="`+item+`">
    <p>Are you sure you want to unzip this item?</p>
</div>`;
    $(".modal-body").html(html);
   $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="unzip">Save changes</button>
        `);;
}
function unzip(i){
    $("#ModalLabel").html("Unzip Item");
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    let html = `
<div class="form-group mt-2">
    <input type="hidden" class="form-control" name="path" value="`+path_dir+`">
    <input type="hidden" class="form-control" name="item" value="`+item+`">
    <p>Are you sure you want to unzip this item?</p>
</div>`;
    $(".modal-body").html(html);
   $(".modal-footer").html(`
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="unzip">Save changes</button>
        `);;
}
function download(i){
    let path_dir = $("#path_dir").val();
    let item = i.attr("data-item");
    
    let path = encodeURIComponent(btoa(path_dir+item));
    
    window.location.href = base_url("Home/Download/"+path);
}
function send(url,html,data = {}){
    $.post(url, function(data, status){
    html.html(data);
  });
}
