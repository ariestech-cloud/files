<sectiion class="p-2">
    <?php Flasher::flash();?>
    <div class="card">
        <form action="" method="post">
        <div class="card-header">
            <div class="form-group">
                <div class="input-group mb-3">
  <button class="btn btn-secondary me-2" type="submit" name="back">Back</button>
  <button class="btn btn-primary" type="submit" name="save">Save</button>
  <input type="text" class="form-control" name="path" value="<?=$data['path'];?>">
</div>
            </div>
            
        </div>
        <div class="card-body">
            <div class="form-group">
                <textarea name="text_file" id="" cols="30" rows="50" class="form-control"><?=$data["code"];?></textarea>
            </div>
        </div>
        </form>
    </div>
</sectiion>
