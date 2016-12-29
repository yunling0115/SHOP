<ul class="products">  
    <?php foreach($products as $p): ?>  
    <li>  
        <h3><?php echo $p['name']; ?></h3>  

        <img src="<?php echo base_url(); ?>assets/img/products/<?php echo $p['image']; ?>" alt="" />  

        <small>&euro;<?php echo $p['price']; ?></small>  
		<!-- We use the form helper to create the form opening tag, and set the action to “cart/add_cart_item” -->
        <?php echo form_open('cart/add_cart_item'); ?>  
            <fieldset>  
                <label>Quantity</label>  
				<!-- This is the part where the user can define the quantity of items he/she wants. 
				We use the form helper again to create an input field with the name “quantity” and set 
				the default value to “1.” We also pass through some extra data – 
				in this case, we set the maxlength to “2.”-->
                <?php echo form_input('quantity', '1', 'maxlength="2"'); ?>  
                <?php echo form_hidden('product_id', $p['id']); ?>  
                <?php echo form_submit('add', 'Add'); ?>  
            </fieldset>  
        <?php echo form_close(); ?>  
    </li>  
    <?php endforeach;?>  
</ul>  

<!-- Location: ./application/view/cart/products.php -->