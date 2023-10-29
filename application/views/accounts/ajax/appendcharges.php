<tr>
    <td>
        <div class="form-group m-b-0">
            <div class="controls">
                <select name="charges[brand_name][]"  class="charges_brand form-control form-control-sm">
                    <option value="">Select Brand</option>
                    <?php 
                        $brands = GetBrands();
                        foreach ($brands as $key => $brand) {
                    ?>
                    <option value="<?php echo $brand['brand_name'] ?>"><?php echo $brand['brand_name'] ?></option>
                    <?php 
                        }
                    ?>
                </select>
            </div>
        </div>
    </td>
    <td>
        <div class="form-group m-b-0">
            <div class="controls">
                <select name="charges[agent_name][]"  class="charges_agent form-control form-control-sm">
                    <option value="">Select Agent</option>
                </select>
            </div>
        </div>
    </td>
    <td>
        <div class="form-group m-b-0">
            <div class="controls">
                <input type="text" name="charges[dr_charges][]" class="form-control form-control-sm" value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-trigger="focusin focusout" data-parsley-error-message="Enter Digits Only"> 
            </div>
        </div>
    </td>
    <td>
        <div class="form-group m-b-0">
            <div class="controls">
                <input type="text" name="charges[cr_charges][]" class="form-control form-control-sm" value="0.00" data-parsley-pattern="^[0-9.]+$" data-parsley-trigger="focusin focusout" data-parsley-error-message="Enter Digits Only">
            </div>
        </div>
    </td>
    <td>
        <div class="form-group m-b-0">
            <div class="controls">
                <select name="charges[charges_type][]"  class="form-control form-control-sm">
                    <option value="">Select type</option>
                    <option value="percentage">Percentage</option>
                    <option value="fixed">Fixed</option>
                </select>
            </div>
        </div>
    </td>
    <td class="p-0-3 text-center text-middle">
        <a class="deletecharges">-</a>
    </td>
</tr>