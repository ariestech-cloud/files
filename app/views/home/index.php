<section class="file-list p-3">
    <?php Flasher::flash();?>
    <div class="card mb-2">
        <div class="card-header">
            <input class="form-control" type="text" id="path_dir" value="<?=$data['dir_path'];?>" readonly autocomplete="off"/>
        </div>
        <div class="card-body">
        <div class="table-responsive">

        <table class="table table-hover" id="dataTable">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tfoot>
                    <tr>
            <td></td>
            <td>
                <?php
                $hex = rtrim($data["dir_path"],"/");
                $hex = explode("/",$hex);
                $i = count($hex);
                
                unset($hex[$i-1]);
                
                $hex = implode("/",$hex);
                
                $hex = urlencode(base64_encode($hex."/"));
                ?>
                <a href="<?=$this->base_url('Home/Index/'.$hex);?>" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                                            <span class="badge text-bg-primary ">
                <i class="fas fa-folder"></i>
                </span>
                        </div>
                        <div class="col">
                            ../
                        </div>
                    </div>
                </div>
                </a>
            </td>
            <td></td>
        </tr>
        </tfoot>
        <tbody>
<form action="" method="post">
            <?php foreach ($data["items"] as $item): ?>
        <tr>
            <td>
                <div class="form-check">
              <input class="form-check-input border-primary input-check" type="checkbox" value="<?=$item;?>" id="flexCheckDefault" name="item_list">
              </div>
            </td>
            <td>

 
                
                <?php if (is_dir($data["dir_path"].$item)): ?>
                    <?php $d = $data["dir_path"].$item."/";
                    $d = urlencode(base64_encode($d));?>
                        <a href="<?=$this->base_url('Home/Index/'.$d);?>" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                <?php else: ?>
                                    <?php $d = $data["dir_path"].$item;
                    $d = urlencode(base64_encode($d));?>
                        <a href="<?=$this->base_url('Home/Fileview/'.$d);?>" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                <?php endif; ?>

                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            <?=$this->model("Model")->check_item($data["dir_path"],$item);?>
                        </div>
                        <div class="col ps-3">
                           <?=$item;?>
                        </div>
                    </div>
                </div>
                </a>
                </td>
            <td>
                <button type="button" class="badge text-bg-primary me-2 mb-2 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="rename" data-item="<?=$item;?>"><i class="fas fa-edit"></i></button>
                <button type="button" class="badge text-bg-primary me-2 mb-2 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="del" data-item="<?=$item;?>"><i class="fas fa-trash-alt"></i></button>
                <button type="button" class="badge text-bg-primary me-2 mb-2 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="copy" data-item="<?=$item;?>"><i class="fas fa-copy"></i></button>
                <button type="button" class="badge text-bg-primary me-2 mb-2 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="move" data-item="<?=$item;?>"><i class="fas fa-folder-open"></i></button>
                    <?php if (pathinfo($item,PATHINFO_EXTENSION) == "zip"): ?>
                                    <button type="button" class="badge text-bg-primary me-2 mb-2 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="unzip" data-item="<?=$item;?>"><i class="fas fa-file-archive"></i></button>
                <?php endif; ?>            
<button type="button" class="badge text-bg-primary me-2 mb-2 btn-action" data-action="download" data-item="<?=$item;?>"><i class="fas fa-file-download"></i></button>
            </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
        </div>
    </div>
    <div class="btn-group">
        <input type="checkbox" class="btn-check" name="btnradio" id="checkin" value="false">
  <label class="btn btn-outline-primary me-1 checkin" for="checkin"><i class="fas fa-check-square fa-fw"></i></label>

  <button type="button" class="btn btn-outline-primary me-1 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="add"><i class="fas fa-plus"></i></button>
<button type="button" class="btn btn-outline-primary me-1 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="del_checked"><i class="fas fa-trash-alt"></i></button>
<button type="button" class="btn btn-outline-primary me-1 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="copy_checked"><i class="fas fa-copy"></i></button>
<button type="button" class="btn btn-outline-primary me-1 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="move_checked"><i class="fas fa-folder-open"></i></button>
<button type="button" class="btn btn-outline-primary me-1 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="download_checked"><i class="fas fa-file-download"></i></button>
<button type="button" class="btn btn-outline-primary me-1 btn-action" data-bs-toggle="modal" data-bs-target="#ActionModal" data-action="upload"><i class="fas fa-file-upload"></i></button>
    </div>
</section>
</form>
