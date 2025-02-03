 <div class="row p-3">
    <nav aria-label="Page navigation example">
      <ul class="pagination pagination-primary pagin-border-primary">
        <li class="page-item"><a class="page-link <?php if($pageno <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?$action_name&pageno=".($pageno - 1); } ?>">Previous</a></li>
        <li class="page-item"><a class="page-link" href="?<?php echo $action_name;?>&pageno=1">1</a></li>
        <!--<li class="page-item"><a class="page-link <?php if($total_pages == '1'  || $total_pages == '2'){ echo 'disabled'; } ?>" href="#">...</a></li>-->
        <!--<li class="page-item"><a class="page-link <?php if($total_pages >='1' ){ echo 'disabled'; } ?>" href="?<?php echo $action_name;?>&pageno=<?php echo $total_pages; ?>"><?php echo $total_pages; ?></a></li>-->
        <li class="page-item"><a class="page-link <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?$action_name&pageno=".($pageno + 1); } ?>">Next</a></li>
      </ul>
    </nav>
</div>
