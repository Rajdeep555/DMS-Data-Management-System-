<?php

$select_bookings111 = "SELECT * FROM `group_mapping` where status = 'Active' and id='7'";
                                $sql111 = $dbconn->prepare($select_bookings111);
                                $sql111->execute();
                                $wlvd111 = $sql111->fetchAll(PDO::FETCH_OBJ);
                                foreach ($wlvd111 as $rows111);
                                $mapping_id = $rows111->id;
                                $grp_map_group = $rows111 ->grp_map_group;
                                $grp_map_sub_gr = $rows111 ->grp_map_sub_group;
                               
                                $sub_grp = explode(',', $grp_map_sub_gr);
                               
                                $sgrp=[];
                                foreach($sub_grp as $i)
                                {
                                
                                //for job type
                                $select_enquiry3 = "SELECT * FROM group where id='$i' and status = 'Active'";
                                $sql3=$dbconn->prepare($select_enquiry3);
                                $sql3->execute();
                                $wlvd3=$sql3->fetchAll(PDO::FETCH_OBJ);
                                
                                // empty array
                                // $job=[];
                                
                                foreach ($wlvd3 as $rows3){
                                    $sgrp[]=$rows3->sub_grp;
                               
                                    }
                                } 
                               
                               
                                echo implode(",",$sgrp);

                                ?>