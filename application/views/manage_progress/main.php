<!--===========================
Manage Progress
============================-->
<style>
    .vertical-divider {
        position: absolute;
        z-index: 10;
        top: 60%;
        left: 40%;
        margin: 0;
        padding: 0;
        width: auto;
        height: 50%;
        line-height: 0;
        text-align:center;
        text-transform: uppercase;
        transform: translateX(-50%);
    }

    .vertical-divider:before, 
    .vertical-divider:after {
        position: absolute;
        left: 20%;
        content: '';
        z-index: 9;
        border-left: 2px solid rgba(34,36,38,.20);
        border-right: 2px solid rgba(255,255,255,.5);
        width: 0;
        height: calc(100% - 1rem);
    }

    .row-divided > .vertical-divider {
        height: calc(50% - 1rem);    
    }

    .vertical-divider:before {
        top: -93%;
    }

    .btn-default {
        background-color: #2BBBAD; }
    .btn-default:hover {
        background-color: #30cfc0 !important; }
    .btn-default:focus, .btn-default:active, .btn-default.active {
        background-color: #1d7d73 !important; }
    .btn-default.dropdown-toggle {
        background-color: #2BBBAD !important; }
    .btn-default.dropdown-toggle:hover, .btn-default.dropdown-toggle:focus {
        background-color: #30cfc0 !important; }

    .indigo {
        background-color: #3f51b5 !important; }

    .btn-indigo {
        background-color: #3f51b5; }
    .btn-indigo:hover {
        background-color: #4d5ec1 !important; }
    .btn-indigo:focus, .btn-indigo:active, .btn-indigo.active {
        background-color: #2b387c !important; }
    .btn-indigo.dropdown-toggle {
        background-color: #3f51b5 !important; }
    .btn-indigo.dropdown-toggle:hover, .btn-indigo.dropdown-toggle:focus {
        background-color: #4d5ec1 !important; }

    .steps-form {
        display: table;
        width: 100%;
        position: relative; }
    .steps-form .steps-row {
        display: table-row; }
    .steps-form .steps-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc; }
    
    .steps-form .steps-row .steps-step {
        display: table-cell;
        text-align: center;
        position: relative; }
    .steps-form .steps-row .steps-step p {
        margin-top: 0.5rem; }
    .steps-form .steps-row .steps-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important; }
    .steps-form .steps-row .steps-step .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
        margin-top: 0; }
    
</style>
<?php
    function get_age($birth_date) {
        if (date("Y", $birth_date) == date("Y")) {
//Month
            return floor((time() - $birth_date) / 2678400) . " months old";
        } else {
//Year
            return floor((time() - $birth_date) / 31556926) . " years old";
        }
    }
?>
<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url()?>AdminDashboard">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url()?>PetManagement">Pet Management</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url()?>PetManagement/interested_adopters_exec/<?= $transaction->pet_id?>">Interested Adopters</a>
            </li>
            <li class="breadcrumb-item active">Manage Progress of <?= $transaction->user_firstname." ".$transaction->user_lastname?></li>
        </ol>
        <?php include_once (APPPATH."views/show_error/show_error.php");?>
        <?php include_once "manage_progress.php";?>
    </div>
    
    
<script>
    $(document).ready(function () {
        switch (<?= $transaction->transaction_progress ?>) {
            case 16:
            {
                $("#step_id_1").addClass("active");
                $("#step_id_2").addClass("disabled");
                $("#step_id_3").addClass("disabled");
                $("#step_id_4").addClass("disabled");
                $("#step_id_5").addClass("disabled");
                $("#step_id_6").addClass("disabled");
                break;
            }
            case 32:
            {
                $("#step_id_1").addClass("");
                $("#step_id_2").addClass("active");
                $("#step_id_3").addClass("disabled");
                $("#step_id_4").addClass("disabled");
                $("#step_id_5").addClass("disabled");
                $("#step_id_6").addClass("disabled");
                $("#step_id_6").addClass("disabled");

                break;
            }
            case 49:
            {
                $("#step_id_1").addClass("");
                $("#step_id_2").addClass("");
                $("#step_id_3").addClass("active");
                $("#step_id_4").addClass("disabled");
                $("#step_id_5").addClass("disabled");
                $("#step_id_6").addClass("disabled");
                break;
            }
            case 66:
            {
                $("#step_id_1").addClass("");
                $("#step_id_2").addClass("");
                $("#step_id_3").addClass("");
                $("#step_id_4").addClass("active");
                $("#step_id_5").addClass("disabled");
                $("#step_id_6").addClass("disabled");
                break;
            }
            case 83:
            {
                $("#step_id_1").addClass("");
                $("#step_id_2").addClass("");
                $("#step_id_3").addClass("");
                $("#step_id_4").addClass("");
                $("#step_id_5").addClass("active");
                $("#step_id_6").addClass("disabled");
                break;
            }
            case 100:
            {
                $("#step_id_1").addClass("");
                $("#step_id_2").addClass("");
                $("#step_id_3").addClass("");
                $("#step_id_4").addClass("");
                $("#step_id_5").addClass("");
                $("#step_id_6").addClass("active");
                break;
            }
        }
    });
</script>
<script>

    $(document).ready(function () {
        var navListItems = $('div.setup-panel div a'),
                allWells = $('.setup-content'),
                allNextBtn = $('.nextBtn'),
                allPrevBtn = $('.prevBtn');

        allWells.hide();

        navListItems.click(function (e) {
            e.preventDefault();
            var $target = $($(this).attr('href')),
                    $item = $(this);
            if (!$item.hasClass('')) {
                navListItems.removeClass('btn-indigo').addClass('btn-default');
                $item.addClass('btn-indigo');
                allWells.hide();
                $target.show();
                $target.find('input:eq(0)').focus();
            }
        });
        $('div.setup-panel div a.active').trigger('click');
    });

</script>