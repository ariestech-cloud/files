    <div class="card mb-2">
        <div class="card-header">
            <input class="form-control" type="text" id="path_dir" value="<?=$data['dir_path'];?>" readonly autocomplete="off" name="to"/>
        </div>
        <div class="card-body">
        <table class="table table-hover">
        <thead>
        <tr>

            <th>Name</th>

        </tr>
        </thead>
        <tfoot>
                    <tr>

            <td>
                <?php
                $hex = rtrim($data["dir_path"],"/");
                $hex = explode("/",$hex);
                $i = count($hex);
                
                unset($hex[$i-1]);
                
                $hex = implode("/",$hex);
                
                $hex = urlencode(base64_encode($hex."/"));
                $url = $this->base_url('Home/Ajax/'.$hex);
                ?>
                <a href="#" class="link-url link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" data-url="<?=$url;?>">
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
        </tr>
        </tfoot>
                <tbody>
            <?php foreach ($data["items"] as $item): ?>
        <tr>

            <td>

 
                
                <?php if (is_dir($data["dir_path"].$item)): ?>
                    <?php $d = $data["dir_path"].$item."/";
                    $d = urlencode(base64_encode($d));
                    $url = $this->base_url('Home/Ajax/'.$d);
                    ?>
                        <a href="#" class="link-url link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" data-url="<?=$url;?>">
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
                <?php endif; ?>
                </td>
        </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </div>
    </div>
    <script>
    $(".link-url").on("click",function(){
    let data = $(this).attr("data-url");
    send(data,$(".modal-body .modal-container"));
})
    </script>