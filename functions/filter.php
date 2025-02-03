<?php

  $user_id = $_SESSION['user_id'];
  
            $select_enquiry11 = "SELECT * FROM `user_mapping` where status = 'Active' and user_map_parent ='$user_id'";
          $sql11 = $dbconn->prepare($select_enquiry11);
          $sql11->execute();
          $wlvd11 = $sql11->fetchAll(PDO::FETCH_OBJ);
          foreach ($wlvd11 as $row11) {
              $child1 = $row11->user_map_child;
              
            
              
              $select_enquiry12 = "SELECT * FROM `user_mapping` where status = 'Active' and user_map_parent ='$child1' ";
          $sql12 = $dbconn->prepare($select_enquiry12);
          $sql12->execute();
          $wlvd12 = $sql12->fetchAll(PDO::FETCH_OBJ);
          foreach ($wlvd12 as $row12) {
              $child2 = $row12->user_map_child;
              
           
                
                  $select_enquiry13 = "SELECT * FROM `user_mapping` where status = 'Active' and user_map_parent ='$child2' ";
          $sql13 = $dbconn->prepare($select_enquiry13);
          $sql13->execute();
          $wlvd13 = $sql13->fetchAll(PDO::FETCH_OBJ);
          foreach ($wlvd13 as $row13) {
              $child3 = $row13->user_map_child;
              
          
                
                $select_enquiry14 = "SELECT * FROM `user_mapping` where status = 'Active' and user_map_parent ='$child3' ";
          $sql14 = $dbconn->prepare($select_enquiry14);
          $sql14->execute();
          $wlvd14 = $sql14->fetchAll(PDO::FETCH_OBJ);
          foreach ($wlvd14 as $row14) {
              $child4 = $row14->user_map_child;
                $a = [];
                // echo $child1;
                // echo ',';
                // echo $child2;
                // echo ',';
                // echo $child3;
                //  echo ',';
                // echo $child4;
                
                $a=  array($user_id, $child1, $child2, $child3, $child4);
                
                // echo $a[1];
            
          }
          }
          echo '<br>';
          }
          echo '<br>';
          }
          
        $z = implode(",",$a);
        // echo $z;
            
?>