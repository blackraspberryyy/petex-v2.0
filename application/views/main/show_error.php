<?php if(!empty($this->session->flashdata("err_1"))):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class = "fa fa-times"></i></strong> <?= $this->session->flashdata("err_1");?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif;?>
<?php if(!empty($this->session->flashdata("err_2"))):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class = "fa fa-times"></i></strong> <?= $this->session->flashdata("err_2");?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif;?>
<?php if(!empty($this->session->flashdata("err_3"))):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class = "fa fa-times"></i></strong> <?= $this->session->flashdata("err_3");?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif;?>
<?php if(!empty($this->session->flashdata("err_4"))):?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class = "fa fa-times"></i></strong> <?= $this->session->flashdata("err_4");?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif;?>