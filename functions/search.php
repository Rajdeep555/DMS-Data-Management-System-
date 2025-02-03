
       
       <?php
             $select_enquiry11 = "SELECT * FROM user_mapping where user_map_parent='$user_id' and status = 'Active'";
            $sql11 = $dbconn->prepare($select_enquiry11);
            $sql11->execute();
            $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
            foreach ($wlvd11 as $rows11);
            $user_map_child = $rows11->user_map_child;
            
            $select_enquiry12 = "SELECT * FROM users where id='$user_map_child' and status = 'Active'";
            $sql12 = $dbconn->prepare($select_enquiry12);
            $sql12->execute();
            $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
            foreach ($wlvd12 as $rows12);
            $u_role = $rows12->user_role;
            if($u_role){
            ?>
<div class="row">
    <div class="col-md-3">
       
            
        <select class="form-select parent" name="parent" onchange="showGroup(this.value)">
            <option value="0">Select <?= $u_role ?></option>
            <?php
            foreach ($wlvd11 as $rows11){
            $user_map_child = $rows11->user_map_child;
            
            $select_enquiry12 = "SELECT * FROM users where id='$user_map_child' and status = 'Active'";
            $sql12 = $dbconn->prepare($select_enquiry12);
            $sql12->execute();
            $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
            foreach ($wlvd12 as $rows12);
            $user_fname = $rows12->user_fname;
            $user_mname = $rows12->user_mname;
            $user_lname = $rows12->user_lname;
            ?>
                <option value="<?php echo $user_map_child; ?>"><?php echo $user_fname; ?> <?php echo $user_mname; ?> <?php echo $user_lname; ?></option>
            <?php
            }
            ?>
          </select>
       
					</div>
    <div  class="col-md-3" id="div1">
        <!--<select id="child1" name="child1"  class="form-select"  onchange="showGroup1(this.value)">-->
        <!--    <option value="0">Select</option>-->
        <!--    </select>-->
					</div>
					 <div  class="col-md-3" id="div2">
    <!--    <select id="child2" name="child2"  class="form-select"  onchange="showGroup2(this.value)">-->
    <!--<option value="0">Select</option>-->
    <!--        </select>-->
					</div>
					<div  class="col-md-3" id="div3">
        <!--<select id="child3" name="child3"  class="form-select"  onchange="showGroup3(this.value)">-->
        <!--     <option value="0">Select</option>-->
        <!--    </select>-->
					</div>
					<div  class="col-md-2" id="div4">
    <!--    <select id="child2" name="child2"  class="form-select"  onchange="showGroup4(this.value)">-->
    <!--<option value="0">Select</option>-->
    <!--        </select>-->
					</div>
					<div  class="col-md-2" id="div5">
    <!--    <select id="child2" name="child2"  class="form-select"  onchange="showGroup4(this.value)">-->
    <!--<option value="0">Select</option>-->
    <!--        </select>-->
					</div>
					<div  class="col-md-2" id="div6">
    <!--    <select id="child2" name="child2"  class="form-select"  onchange="showGroup4(this.value)">-->
    <!--<option value="0">Select</option>-->
    <!--        </select>-->
					</div>
					</div>
					<?php
            }
					if($u_role){
					    ?>
					<div class="row m-2" >
			  <button type="submit" name="search" value="search" id="button"  class="btn btn-primary"  >Search</button>
			  </div>
			  <?php
					}
					?>
			  
		
		
		
<script>
    	function showGroup(str) {
  if (str == "") {
    document.getElementById("div1").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("div1").innerHTML = this.responseText;
  }
  xhttp.open("GET", "controllers/ajax/child.php?group="+str);
  xhttp.send();


// alert('Hello ' + str);
}

function showGroup1(str) {
  if (str == "") {
    document.getElementById("div2").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("div2").innerHTML = this.responseText;
  }
  xhttp.open("GET", "controllers/ajax/child1.php?group="+str);
  xhttp.send();



// alert('Hello ' + str);
}

function showGroup2(str) {
  if (str == "") {
    document.getElementById("div3").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("div3").innerHTML = this.responseText;
  }
  xhttp.open("GET", "controllers/ajax/child2.php?group="+str);
  xhttp.send();



// alert('Hello ' + str);
}

function showGroup3(str) {
  if (str == "") {
    document.getElementById("div4").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("div4").innerHTML = this.responseText;
  }
  xhttp.open("GET", "controllers/ajax/child3.php?group="+str);
  xhttp.send();



// alert('Hello ' + str);
}


function showGroup4(str) {
  if (str == "") {
    document.getElementById("div5").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("div5").innerHTML = this.responseText;
  }
  xhttp.open("GET", "controllers/ajax/child4.php?group="+str);
  xhttp.send();



// alert('Hello ' + str);
}

function showGroup5(str) {
  if (str == "") {
    document.getElementById("div6").innerHTML = "";
    return;
  }


  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("div6").innerHTML = this.responseText;
  }
  xhttp.open("GET", "controllers/ajax/child5.php?group="+str);
  xhttp.send();



// alert('Hello ' + str);
}

</script>