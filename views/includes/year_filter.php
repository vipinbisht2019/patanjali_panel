 <div class="col-sm-3">
    <label class="filter-label">Year</label>
          <select class="form-control" id="filterYear">
              
    <?php foreach(range((int)date("Y"), 2018) as $year) {
        
                $yearRange = $year+1;
                $disable ="";
                
                if( date("m") < 4 && $year == date("Y"))
                   $disable =" disabled='disabled' ";
                
                
        echo "<option value='".$year."' $disable >".$year." - ".$yearRange."</option>";
         }

    ?>
              
         
    </select>
 </div>