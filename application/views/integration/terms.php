<div class="modal-header">
    <h6 class="modal-title m-0 text-center d-block w-100 ">
        Terms
    </h6>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body m-0 p-0">
    <div class="modal-ins">
        
        <div class="modal-ins-body">
            <?php
                if(!empty($terms_data['terms']))
                {
                    echo $terms_data['terms'];
                }
                else
                {
                    echo "There is not terms available";
                }
            ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>