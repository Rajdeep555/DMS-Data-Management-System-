<?php
 
    echo '<div class="row" id>
        <div class="col-md-2"></div>
        <div id="input_fields">
        <div class="col-md-4">
            <input class="form-control" name="input_1" type="text" placeholder="Parent Group" required>
        </div>
        <div class="col-md-4">
            <input class="form-control" name="subinput_1" type="text" placeholder="Sub Group" required>
        </div>
        </div>
        <div class="col-md-2">
            <button class="btn  btn-sm btn-success me-3" type="submit" name="add" value="add" id="add_input">Add More</button>
        </div>
    </div>';

?>

<script>
  var count = 1;

  document.getElementById("add_input").addEventListener("click", function() {
    var input_div = document.getElementById("input_fields");
    var new_input = document.createElement("input");
    new_input.setAttribute("type", "text");
    new_input.setAttribute("name", "input_" + (++count));
    new_input.setAttribute("name", "subinput_" + (++count));
    input_div.appendChild(new_input);
  });
</script>