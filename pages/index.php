
<?php
ob_start(); 
session_start();
session_regenerate_id();
if(isset($_SESSION["showcolor"])){$_SESSION["showcolor"]="NO";}
if (isset($_SESSION["username"])&& isset($_SESSION["userid"])){
$set_navbar="";
$language_is="";
$page_titel="Admin Page";
include "init.php";
$userinfo=$mycrud->fetch_tab($conn,"user",$_SESSION["userid"],"id");
define("USER_INFO",$userinfo);
if(isset($_GET["was"])){$was=$_GET["was"];}else{$was="default";}
echo "<a href='?was=add'><div class='add-item_btn'><i class='fas fa-plus'></i></div></a>";

//check if user is admin
if (USER_INFO[0]["groupID"]=='1'){
  
// include the first section of page like header and navbar
include $tmplate_path."header.php";
if(isset($set_navbar)){include $tmplate_path."navbar.php";}

if ($was=="default"){
$function->show_alert_div("alert alert-info mt-5","Sorry Admin We Will Edit this Page Later");

}
    
//edit this Later
else if ($was == "modify_account"){
    $function->show_alert_div("alert alert-info mt-5","Sorry Admin We Will Edit Modify Account Later Kein Lust Drauf");
}




    
    else if($was=="add"){
    ?>
    <div class="myaddbody">
        <div class="add-item-page">
            <div class="container">
                <h1 class="text-center page-titel ">Welcome <b><?= $_SESSION['username']?></b> To Add New Item Page Your Are <?=(USER_INFO[0]["groupID"] == '1') ? "Admin" : "User" ?></h1>
                <div class="myrow row ">
                    <div class="col-lg-6 col-12 ">
                        <form enctype= multipart/form-data action="?was=insert" class="form-add-item col-11" id="formi" method="post">
                            <div class="mb-3">
                                <label for="prod_name" class="form-label">Product Name</label>
                                <input maxlength="35" type="text" value="" class="form-control" id="prod_name" name="prod_name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-floating mb-3">
                                <textarea  style="height: 200px" rows="4" cols="50" value="bfdf"  class="form-control" id="desc" name="prod_desc"></textarea>
                                <label  for="desc">Description</label>
                            </div>
                            <div class="mb-3">
                                <label for="price" value=""  class="form-label">Price</label>
                                <input min="1" max="999999999" type="number" name="prod_price" class="form-control" id="price">
                            </div>
                            <div class="up-file input-group mb-4">
                                <div class="up_txt">Upload Photo</div>
                                <input accept="image/*" type="file" name="image" class="form-control" id="image-up">
                            </div>
                            <div class="all_btn">
                                <button id="clear-input-field" type="button" class="btn btn-danger clear-btn">clear</button>
                                <button type="submit" id="add-btn" class="btn btn-primary btn-add-item">Add</button> 
                            </div>              
                        </form>
                    </div>
                    <div class="col-lg-6 col-12 center-card">
                        <div class="card mycard width-card card-float-left  ">
                            <div class="Price-area" id="card_price"><span id="money">0</span> <span><?php if (isset($_COOKIE["currency"])){echo $_COOKIE["currency"];}else{echo "TND";}?></span></div>
                            <img id="img_display_add" src="../images/default-product.png"  class="card-img-top myimg" alt="Add Photo">
                            <div class="card-body mycardbody">
                                <h5 class="card-title mytitel" titel="" id="card_name">Card title</h5>
                                <p class="card-text mydesc" id="card-desc"> Here Stand Your Decreption</p>
                            <br>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>  
        </div>
    </div>
    <?php
    
    }
    
    
    
    


    
else if($was=="modify"){

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$error=$function->check_required_input_fields([$_POST['titel'],$_POST['price'],$_POST['desc'],$_POST['currency']]);
    if(count($error)>0){
        $function->show_alert_div("alert-danger",$error[0]);
//no error 
    }else{
//update
    $function->show_alert_div("alert-success mt-5",$mycrud->modify_row_in_db($conn,$_POST['titel'],$_POST['desc'],$_POST['price'],$_POST['currency'],$_POST["user_id"]));
    header( "refresh:1;url= ?was=show");}
}else if(!isset($_GET['id'])){header("Location:index.php");}


$idd=(isset($_GET['id'])) ? $_GET['id'] : -103;
$get_mod_id=$function->get_id_colmn($idd);
if($get_mod_id!=-103){

$id_exist=$mycrud->check_if_in_db_admin($conn,"items","item_id",$get_mod_id,$_SESSION['userid']);
if ($id_exist){
            
                $datas= $mycrud->fetch_tab2($conn,"items",$_SESSION['userid'],$get_mod_id);

?>
    <h1 class=" myh1 text-center mt-4">Item Modification Page</h1>  
    <div class="container mycont">                                  
        <form class="row mb-4 mt-4 g-0 modify-form " action="index.php?was=modify" method="post">
            <div class="mt-3">
                <label for="tit" class="form-label mylabel">Item Titel</label>
                <input type="text" class="form-control" name="titel"  value="<?=$datas[0]["item_titel"] ?>" id="tit" >
            </div>
            <div class="mt-3">
                <label for="desc" class="form-label mylabel">Descritption</label>
                <textarea  name="desc" class="form-control" id="desc" rows="3"><?= $datas[0]["item_desc"] ?></textarea>
            </div>
            <div class="mt-3">
                <label for="price" class="form-label mylabel">Item Price</label>
                <input type="number" class="form-control" name="price"  value="<?=$datas[0]["item_price"] ?>"  id="price" >
            </div>
            <select class="form-select form-select-lg mb-3 mt-3 myselect_update" aria-label=".Choose Your Currency" name="currency" id="">
                    <?php foreach($allcurrency as $cur){
                        ?>
                    <option <?php if($cur==$datas[0]["item_currency"]){echo "selected";} ?> value="<?= $cur ?>"><?= $cur ?></option>;
                    <?php
                    } ?>
            </select>
            <input type="hidden" value="<?= $get_mod_id ?>" name="user_id">
            <button type="submit"  class="btn btn-success btn-add-item update_btnn" >Update</button>
        
        </form>
        
    </div>
    
    
    
    
    
    
    <?php
                                            }else{
    
                                                if(isset($_GET['id'])){
                                                    $function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");
                                                }
                                               
                                            }
                            
    
                            // $errors=$function->Controle_upload_file("image");
                            // $test_errors= $function->check_required_input_fields([$_POST['prod_name'],$_POST['prod_desc'],$_POST['prod_price']]);
    
    
                            }else {
                                if(isset($_GET['id'])){
                                    $function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");
                                }
                            }
    //end modify page
    }





else if($was=="show"){
$items=$mycrud->fetch_tab_admin($conn,$_SESSION['userid']);
if(count($items)== 0){ echo "<h1 class='text-center mt-5'>There is No Item</h1>";}else{ echo "<h1 class='text-center mt-5'>Show All My Publiaction</h1>";}
echo '<div class="container position-relative ">';
echo '<div class="view mt-5  mb-5">
                <div class="view_titel">View : </div>
                <div class="show_it_tab "><a  href="?was=ShowTab">Table</a></div> 
                <div class="show_it_tab"><a class="active" href="?was=show">Custom</a></div> 
             </div>';   
    echo '<div class="row mt-5 mb-5">';
foreach( $items as $index=>$item){     
?>
<div class="col-12 card-block mb-3 position-relative">
    <?= ($item["item_status"]=='0') ? '<div class="overlay "></div>' : "" ?>
    <div class="my-show-card mt-4  g-0">
        <div class="img-div">
            <img src="<?php echo $item["item_photo"]?>" class="card-img-top " alt="...">
        </div>
        <div class="card-body ">
            <h5 class="show-card-title"><?php echo $item["item_titel"]?></h5>
            <p class="show-card-text"><?php echo $item["item_desc"]?></p>
        </div>
        <div class="show-btns-div p-2">
            <button type="button" class="btn btn-<?php if($item['item_status']=="1"){echo 'primary';}else{echo "success";}?> "> <a href="?was=<?php if($item['item_status']=='1'){echo 'Disapprove';}else{echo 'Approve';}?>&id=<?= $item['item_id'] ?> " > <?php if($item['item_status']=="1"){echo "Disapprove";}else{echo "Approve";}?></a></button> 
            <button type="button" class="btn mx-2 btn-warning"><a href='?was=modify&id=<?=$item["item_id"]?>'>Modify</a></button>
            <button  type="button"  class=" btn btn-danger me-3 show_delete"><a onclick="return confirm('Are you sure?')" href='?was=delete&id=<?=$item["item_id"]?>'>Delete</a></button>
        </div>
        <div class="show-money"><?=$item["item_price"]." ".$item["item_currency"] ?> </div>
    </div> 
</div>
<?php  
//end foreach    
}
    echo'</div>';
echo'</div>';
//end show    
}







else if($was=="Add_Categorie"){
echo'<div class="container ">'; 
  echo "<h1 class='text-center mt-5'>Add Categories</h1>";
    echo'<form method="post" action="?was=insert_cat" class=" row mt-5 align-items-center flex-column">';
        echo'
            <div class=" col-12 col-md-8 col-lg-6 mb-3">
                <input type="text" name="cat_name" class="form-control" id="exampleFormControlInput1" placeholder="Category Name">
            </div>
            <div class=" col-12 col-md-8 col-lg-6 mb-3">
                 <textarea placeholder="Describtion" name="cat_desc" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="col-12 col-md-8 col-lg-6 form-check mb-3 margin-0 form-switch">
                <label class="form-check-label" for="flexSwitchCheckDefault">Visibility</label>
                <input class="form-check-input"name="cat_status" type="checkbox" id="flexSwitchCheckDefault">
            </div>
            <div class=" col-12 col-md-8 col-lg-6 mb-3 justify-content-end width-100 d-flex">
                <button type="submit" class=" btn btn-success">Add</button>
            </div>
            ';
    echo'</form>';
    //end container
echo'</div>'; 


// end  add cat
}

else if($was=="insert_cat"){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $test_errors= $function->check_required_input_fields([$_POST['cat_desc'], $_POST['cat_name']]);  
        if(empty($test_errors) ){
            //insert into database if no errors
            echo "do it";
            header("Refresh:3; url=?was=Add_Categorie");
        }else{
            // print the errors
            foreach($test_errors as $test_error){$function->show_alert_div("alert-danger",$test_error);}
            header("Refresh:2; url=?was=Add_Categorie");
        }
    }else{header('Location:?was=Add_Categorie');}
    
    //end insert
    }







else if($was=="ShowTab"){
    $items=$mycrud->fetch_tab_admin($conn,$_SESSION["userid"]);
    if(count($items)== 0){ echo "<h1 class='text-center mt-5'>There is No User Working Under You</h1>";}else{
    echo'<div class="container ">'; 
        echo "<h1 class='text-center mt-5 mb-5'>Mananging Item Page</h1>";       
        echo '<div class="table-responsive position-relative">';
        echo '<div class="view mb-5">
                <div class="view_titel">View : </div>
                <div class="show_it_tab "><a  class="active" href="?was=ShowTab">Table</a></div> 
                <div class="show_it_tab"><a href="?was=show">Custom</a></div> 
              </div>';   
            echo '<table class="table  show-user-tab">';
                echo '<tr class="table-dark">';
                    echo'<th>Id</th>';
                    echo'<th>Item Titel</th>';
                    echo'<th>Item Description</th>';
                    echo'<th>Price</th>';
                    echo'<th>Add At:</th>';
                    echo'<th>Owner</th>';
                    echo'<th class="text-center">Action</th>';
                echo '</tr>';
                foreach($items as $key => $val){
                    $who= ($val['this_user_works_under']==Null) ? "You" :  $val['this_user_works_under'];
                    $status=($val['item_status']=="0") ? "approve_tr_color" :"" ;
                echo '<tr class='. $status.'>';
                    echo'<td>'.$val['item_id'].'</td>';
                    echo'<td>'.$val['item_titel'].'</td>';
                    echo'<td>'.$val['item_desc'].'</td>';
                    echo'<td>'.$val['item_price'].$val['item_currency'].'</td>';
                    echo'<td>'.$val['item_upload_date'].'</td>';
                    echo'<td>'.$who.'</td>';
                    echo'<td>';
                    echo'<div class="btn_behalter">';
                    ?> 
                        <button type="button" class="btn btn-<?php if($val['item_status']=="1"){echo 'primary';}else{echo "success ";}?> "> <a href="?was=<?php if($val['item_status']=='1'){echo 'Disapprove';}else{echo 'Approve';}?>&id=<?= $val['item_id'] ?> " > <?php if($val['item_status']=="1"){echo "Disapprove";}else{echo "Approve";}?></a></button> 
                        <button type="button" class="btn mx-2 btn-warning"><a href='?was=modify&id=<?=$val["item_id"]?>'>Modify</a></button>
                        <button  type="button"  class="btn btn-danger show_delete  fix-a-btn  me-3 show_delete"><a onclick="return confirm('Are you sure?')" href='?was=delete&id=<?=$val["item_id"]?>'>Delete</a></button>
                    <?php 
                    echo'</div>';
                    echo'</td>';
                echo '</tr>';
                }
            echo  '</table>';
        echo '</div>';
    echo '</div>';
        }
    //end mange user
    }
        
    






else if($was=="MangeUser"&&USER_INFO[0]["groupID"]=='1'){
if (USER_INFO[0]["groupID"]=='1'){
$users=$mycrud->fetch_tab_user_managing($conn,$_SESSION["userid"]);
if(count($users)== 0){ echo "<h1 class='text-center mt-5'>There is No User Working Under You</h1>";}else{
echo'<div class="container">';  
    echo "<h1 class='text-center mt-5 mb-5'>Mananging User Page</h1>";
    echo '<div class="table-responsive">';
        echo '<table class="table  show-user-tab">';
            echo '<tr class="table-dark">';
                echo'<th>Id</th>';
                echo'<th>UserName</th>';
                echo'<th>Email</th>';
                echo'<th>registered Date</th>';
                echo'<th>Action</th>';
            echo '</tr>';
            foreach($users as $key => $val){
            echo '<tr>';
                echo'<td>'.$val['id'].'</td>';
                echo'<td>'.$val['username'].'</td>';
                echo'<td>'.$val['email'].'</td>';
                echo'<td>'.$val['registered Date'].'</td>';
                echo'<td>';
                echo'<div class="btn_behalter">';
                ?> 
                <button type="button" class=" mx-2 btn btn-<?php if($val['zugangberichtigung']=="1"){echo "warning";}else{echo "success";}?> show_delete fix-a-btn"><a href="?was=<?php if($val['zugangberichtigung']=="1"){echo "kill_user";}else{echo "approve_user";}?>&id=<?=$val['id']?>"><?php if($val['zugangberichtigung']=="1"){echo "Kill";}else{echo "Activate";}?></a></button> 
                <button type="button" class="btn btn-danger show_delete  fix-a-btn "><a onclick="return confirm('If You Delete This User Will Lose All Publication Are You Sure?')" href="?was=delete_user&id=<?=$val['id']?>">Delete</a></button>
                <?php
                echo'</div>';
                echo'</td>';
            echo '</tr>';
            }
        echo  '</table>';
    echo '</div>';
echo '</div>';
    }
}else{ echo "<h1 class='text-center mt-5'>You Are Not Admin</h1>";}
//end mange user
}
    




else if($was=="kill_user"&&isset($_GET['id'])&&USER_INFO[0]["groupID"]=='1'){
$get_id= $function->get_id_colmn($_GET['id']);
if($get_id!=-103){
    $id_exist=$mycrud->check_if_in_db1($conn,"user","id",$get_id,);
    if ($id_exist){
        $function->show_alert_div(" alert-succes mt-5 alert-font-size",$mycrud->change_value_of_column($conn,"user","zugangberichtigung",0,"id",$get_id));
        header( "refresh:1;url=?was=MangeUser");
    }else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
}else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
// end kill user
}



     
else if($was=="insert"){
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //check if size and extention is accepted
    $errors=$function->Controle_upload_file("image");
    $test_errors= $function->check_required_input_fields([$_POST['prod_name'],$_POST['prod_desc'],$_POST['prod_price']]);
    foreach($test_errors as $test_error){$errors[]=$test_error;}  
        if(empty($errors) ){
            //insert into database if no errors
            $mycrud->add_new_item($conn,$_SESSION["userid"]);
            header("Refresh:3; url=?was=add");
        }else{
            // print the errors
            foreach($errors as $error){$function->show_alert_div("alert-danger",$error);}
            header("Refresh:10; url= index.php");
        }
    }else{header('Location:?was=add');}
    
    //end insert
    }
    
    
    else if($was=="delete"&&isset($_GET['id'])){
    //must delete the file too 
    $get_id= $function->get_id_colmn($_GET['id']);
    if($get_id!=-103){
        $id_exist=$mycrud->check_if_in_db_admin($conn,"items","item_id",$get_id,$_SESSION['userid']);
        if ($id_exist){
            if($mycrud->delete_form_db_admin($conn,"items","item_id",$get_id,$_SESSION['userid'])){
                $function->show_alert_div(" alert-success mt-5 alert-font-size","This Item was Been Deleted Succefully");
                header( "refresh:2;url=?was=show");
            }
        }else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
    }else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
    // end delete
    }
      
    
else if($was=="Approve"&&isset($_GET['id'])&&USER_INFO[0]["groupID"]=='1'){
$get_id= $function->get_id_colmn($_GET['id']);
if($get_id!=-103){
    $id_exist=$mycrud->check_if_in_db_admin($conn,"items","item_id",$get_id,$_SESSION['userid']);
    if ($id_exist){
        $function->show_alert_div("  alert-success  mt-5 alert-font-size",$mycrud->change_value_of_column($conn,"items","item_status",1,"item_id",$get_id)); 
        header( "refresh:1;url=?was=show");
    }else{$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
}else{$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
// end approve
}


        
else if($was=="Disapprove"&&isset($_GET['id'])&&USER_INFO[0]["groupID"]=='1'){
$get_id= $function->get_id_colmn($_GET['id']);
if($get_id!=-103){
    $id_exist=$mycrud->check_if_in_db_admin($conn,"items","item_id",$get_id,$_SESSION['userid']);
    if ($id_exist){
        $function->show_alert_div(" alert-success mt-5 alert-font-size",$mycrud->change_value_of_column($conn,"items","item_status",0,"item_id",$get_id)); 
        header( "refresh:1;url=?was=show");
    }else{$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
}else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
// end approve
}



    
else if($was=="delete_user"&&isset($_GET['id'])&&USER_INFO[0]["groupID"]=='1'){
    //must delete the file too 
    $get_id= $function->get_id_colmn($_GET['id']);
    if($get_id!=-103){
        $id_exist=$mycrud->check_if_in_db1($conn,"user","id",$get_id);
        if ($id_exist){
                        if($mycrud->delete_user_form_db($conn,"user","id",$get_id)){
                        $function->show_alert_div(" alert-success mt-5 alert-font-size","This User has Been Deleted Succefully");
                        header( "refresh:2;url=?was=MangeUser");}
        }else{$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
    }else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
    // end delete
    }
    



else if($was=="approve_user"&&isset($_GET['id'])&&USER_INFO[0]["groupID"]=='1'){
$get_id= $function->get_id_colmn($_GET['id']);
if($get_id!=-103){
    $id_exist=$mycrud->check_if_in_db1($conn,"user","id",$get_id,);
    if ($id_exist){
        $function->show_alert_div(" alert-succes mt-5 alert-font-size",$mycrud->change_value_of_column($conn,"user","zugangberichtigung",1,"id",$get_id));
        header( "refresh:1;url=?was=MangeUser");
    }else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
}else {$function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");}
// end aprove user
}
    
    
    
    
//log out 
else if ($was=="log_out"){header("Location:log_out_page.php");}
    
    
    
    
//if the address is beeing missed up 
else{
 header("Location:index.php");
}
 
include $tmplate_path."footer.php";








// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================
// ===================================================================================================================================

//start Normal User Pge




//end check if admin or user works under admin
}else{
//check if user can use his account 
if(isset($_GET["was"])){$was=$_GET["was"];}else{$was="default";}
$set_navbar="";
// $language_is="";
$page_titel="User Page";
// include "init.php";
// $userinfo=$mycrud->fetch_tab($conn,"user",$_SESSION["userid"],"id");
// define("USER_INFO",$userinfo);

if(USER_INFO[0]['zugangberichtigung']=='1'){
// include the first section of page like header and navbar
include $tmplate_path."header.php";
if(isset($set_navbar)){include $tmplate_path."navbar.php";} 

if ($was=="default"){
$function->show_alert_div("alert alert-info mt-5","Sorry We Will Edit this Page Later");
}

//edit this Later
else if ($was == "modify_account"){
    $function->show_alert_div("alert alert-info mt-5","Sorry We Will Edit Modify Account Later Kein Lust Drauf");
}


else if($was=="add"){
    ?>
    <div class="myaddbody">
        <!-- starting choosing currency-->  
        <ul class="wahrung">
            <div class="wharung-li">choose your currency</div>
            <li data-wahrnug="TND" class="wharung-li <?php if (isset($_COOKIE["currency"])&&($_COOKIE["currency"]=="TND")){echo " active";}?>"><a href="index.php?was=add&currency=TND">Tunisian currency<span>tnd</span></a></li>
            <li data-wahrnug="EURO" class="wharung-li<?php if (isset($_COOKIE["currency"])&&($_COOKIE["currency"]=="EURO")){echo " active";}?> "><a href="index.php?was=add&currency=EURO">European currency<span>euro</span></a></li>
            <li data-wahrnug="usa" class="wharung-li<?php if (isset($_COOKIE["currency"])&&($_COOKIE["currency"]=="USA")){echo " active";}?>  "><a href="index.php?was=add&currency=USA">american currency<span>usa</span></a></li>
        </ul>
        <!-- end choosing currency     -->
        <div class="add-item-page">
            <div class="container">
                <h1 class="text-center page-titel ">Welcome <b><?= $_SESSION['username']?></b> To Add New Item Page Your Are <?=(USER_INFO[0]["groupID"] == '1') ? "Admin" : "User" ?></h1>
                <div class="myrow row ">
                    <div class="col-lg-6 col-12 ">
                        <form enctype= multipart/form-data action="?was=insert" class="form-add-item col-11" id="formi" method="post">
                            <div class="mb-3">
                                <label for="prod_name" class="form-label">Product Name</label>
                                <input maxlength="35" type="text" value="" class="form-control" id="prod_name" name="prod_name" aria-describedby="emailHelp">
                            </div>
                            <div class="form-floating mb-3">
                                <textarea  style="height: 200px" rows="4" cols="50" value="bfdf"  class="form-control" id="desc" name="prod_desc"></textarea>
                                <label  for="desc">Description</label>
                            </div>
                            <div class="mb-3">
                                <label for="price" value=""  class="form-label">Price</label>
                                <input min="1" max="999999999" type="number" name="prod_price" class="form-control" id="price">
                            </div>
                            <div class="up-file input-group mb-4">
                                <div class="up_txt">Upload Photo</div>
                                <input accept="image/*" type="file" name="image" class="form-control" id="image-up">
                            </div>
                            <div class="all_btn">
                                <button id="clear-input-field" type="button" class="btn btn-danger clear-btn">clear</button>
                                <button type="submit" id="add-btn" class="btn btn-primary btn-add-item">Add</button> 
                            </div>              
                        </form>
                    </div>
                    <div class="col-lg-6 col-12 center-card">
                        <div class="card mycard width-card card-float-left  ">
                            <div class="Price-area" id="card_price"><span id="money">0</span> <span><?php if (isset($_COOKIE["currency"])){echo $_COOKIE["currency"];}else{echo "TND";}?></span></div>
                            <img id="img_display_add" src="../images/default-product.png"  class="card-img-top myimg" alt="Add Photo">
                            <div class="card-body mycardbody">
                                <h5 class="card-title mytitel" titel="" id="card_name">Card title</h5>
                                <p class="card-text mydesc" id="card-desc"> Here Stand Your Decreption</p>
                            <br>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>  
        </div>
    </div>
    <?php
    
    }
    
    
    
    
    
    else if($was=="insert"){
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            //check if size and extention is accepted
            $errors=$function->Controle_upload_file("image");
            $test_errors= $function->check_required_input_fields([$_POST['prod_name'],$_POST['prod_desc'],$_POST['prod_price']]);
            foreach($test_errors as $test_error){$errors[]=$test_error;}      
            if(empty($errors) ){
                    //insert into database if no errors
                    
                    $mycrud->add_new_item_not_admin($conn,$_SESSION["userid"],$_SESSION["derman"]);
                    header("Refresh:1; url= ?was=add");
            } else{
                // print the errors
                foreach($errors as $error){
                    $function->show_alert_div("alert-danger",$error);
                }
                header("Refresh:10; url= index.php");
            }
        }else{
        header('Location:?was=add');
            }
    
    //end insert
    }
    
    
    else if($was=="delete"&&isset($_GET['id'])){
        //must delete the file too 
    $get_id= $function->get_id_colmn($_GET['id']);
    if($get_id!=-103){
    $id_exist=$mycrud->check_if_in_db($conn,"items","item_id",$get_id,$_SESSION['userid']);
            if ($id_exist){
    
                        if($mycrud->delete_form_db($conn,"items","item_id",$get_id,$_SESSION['userid'])){
                            $function->show_alert_div(" alert-success mt-5 alert-font-size","This Item was Been Deleted Succefully");
                                if (isset($_SERVER["HTTP_REFERER"])) {
                                    header( "refresh:2;url= ".$_SERVER["HTTP_REFERER"]);
                                }else{header( "refresh:2;url= index.php ");}
                        }
            }else{
    
                $function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");
            }
    
    }else {
    
        $function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");
     }
    
    
    
    // end delete
    }
    
    
    
    else if($was=="modify"){
    
                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
                                                $error=$function->check_required_input_fields([$_POST['titel'],$_POST['price'],$_POST['desc'],$_POST['currency']]);
                                                if(count($error)>0){
                                                    $function->show_alert_div("alert-danger",$error[0]);
                                                //no error 
                                                }else{
                                                    //update
                                                    $function->show_alert_div("alert-success mt-5",$mycrud->modify_row_in_db($conn,$_POST['titel'],$_POST['desc'],$_POST['price'],$_POST['currency'],$_POST["user_id"]));
                                                    header( "refresh:1;url= ?was=show");
                                                    
                                                    }
                                           
                                
                                }else if(!isset($_GET['id'])){header("Location:index.php");}
    
                                
                                $idd=(isset($_GET['id'])) ? $_GET['id'] : -103;
                             $get_mod_id=$function->get_id_colmn($idd);
                            if($get_mod_id!=-103){
                                
                                    $id_exist=$mycrud->check_if_in_db($conn,"items","item_id",$get_mod_id,$_SESSION['userid']);
                                            if ($id_exist){
                                            
                                               $datas= $mycrud->fetch_tab2($conn,"items",$_SESSION['userid'],$get_mod_id);
    
    ?>
    <h1 class=" myh1 text-center mt-4">Item Modification Page</h1>  
    <div class="container mycont">                                  
        <form class="row mb-4 mt-4 g-0 modify-form " action="index.php?was=modify" method="post">
            <div class="mt-3">
                <label for="tit" class="form-label mylabel">Item Titel</label>
                <input type="text" class="form-control" name="titel"  value="<?=$datas[0]["item_titel"] ?>" id="tit" >
            </div>
            <div class="mt-3">
                <label for="desc" class="form-label mylabel">Descritption</label>
                <textarea  name="desc" class="form-control" id="desc" rows="3"><?= $datas[0]["item_desc"] ?></textarea>
            </div>
            <div class="mt-3">
                <label for="price" class="form-label mylabel">Item Price</label>
                <input type="number" class="form-control" name="price"  value="<?=$datas[0]["item_price"] ?>"  id="price" >
            </div>
            <select class="form-select form-select-lg mb-3 mt-3 myselect_update" aria-label=".Choose Your Currency" name="currency" id="">
                    <?php foreach($allcurrency as $cur){
                        ?>
                    <option <?php if($cur==$datas[0]["item_currency"]){echo "selected";} ?> value="<?= $cur ?>"><?= $cur ?></option>;
                    <?php
                    } ?>
            </select>
            <input type="hidden" value="<?= $get_mod_id ?>" name="user_id">
            <button type="submit"  class="btn btn-success btn-add-item update_btnn" >Update</button>
        
        </form>
        
    </div>
    
    
    
    
    
    
    <?php
                                            }else{
    
                                                if(isset($_GET['id'])){
                                                    $function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");
                                                }
                                               
                                            }
                            
    
                            // $errors=$function->Controle_upload_file("image");
                            // $test_errors= $function->check_required_input_fields([$_POST['prod_name'],$_POST['prod_desc'],$_POST['prod_price']]);
    
    
                            }else {
                                if(isset($_GET['id'])){
                                    $function->show_alert_div(" alert-warning mt-5 alert-font-size","There is No Such Item");
                                }
                            }
    //end modify page
    }
    
    
    
    
    
    
    else if($was=="show"){
     $items=$mycrud->fetch_tab($conn,"items",$_SESSION['userid']);
    if(count($items)== 0){ echo "<h1 class='text-center mt-5'>There is No Item</h1>";}else{ echo "<h1 class='text-center mt-5'>Show All My Publiaction</h1>";}
    echo '<div class="container ">';
        echo '<div class="row mt-5 mb-5">';
        foreach( $items as $index=>$item){     
        ?>
        <div class="col-12 card-block mb-3 position-relative">
            <?= ($item["item_status"]=='0') ? '<div class="overlay "></div>' : "" ?>
            <div class="my-show-card mt-4  g-0">
                <div class="img-div">
                    <img src="<?php echo $item["item_photo"]?>" class="card-img-top " alt="...">
                </div>
                <div class="card-body ">
                    <h5 class="show-card-title"><?php echo $item["item_titel"]?></h5>
                    <p class="show-card-text"><?php echo $item["item_desc"]?></p>
                </div>
                <div class="show-btns-div">
                    <button type="button" class="btn btn-warning"><a href='?was=modify&id=<?=$item["item_id"]?>'>Modify</a></button>
                    <button  type="button"  class=" btn btn-danger mx-2 show_delete"><a onclick="return confirm('Are you sure?')" href='?was=delete&id=<?=$item["item_id"]?>'>Delete</a></button>
                </div>
                <div class="show-money"><?=$item["item_price"]." ".$item["item_currency"] ?> </div>
            </div> 
        </div>
        <?php
        
        
        //end foreach    
        }
        
    
        echo'</div>';
    echo'</div>';
    //end show    
    }
    
    
    
    
    
    
    
    



//log out area
else if ($was=="log_out"){
header("Location:log_out_page.php");
}

























//if the address is beeing missed up 
else{
header("Location:index.php");
}





include $tmplate_path."footer.php";

//user cant use his account
}else{
$function->show_alert_div("alert-danger","Your profile is destroyed");
}

//end Worker User Page
}




//end check session
}else{header("Location:log_out_page.php");}
ob_end_flush();
?> 




