<html>

<body>
    <form action="execute_qid.php" method='post' target='_blank'>
        <div class="containerText">Token</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='token' title='Stock2Shop valid token' required></textarea>

        <div class="containerText">Source ID</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='source_id' title='Source ID'></textarea>

        <div class="containerText">Channel ID</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='channel_id' title='Channel ID'></textarea>

        <div class="containerText">Limit</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='limit' title='Limit' required>50</textarea>

        <div class="containerText">Offset</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='offset' title='Offset' required>0</textarea>

        <div class="containerText">Retry Count</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='retry_counter' title='Retry Count' required>50</textarea>

        <div class="containerText">Limit by Date</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='date_limit' title='Limit by Date' required><?php echo (date("Y-m-d h:i:s")); ?></textarea>

        <div class="containerText">Error Message</div>
        <div class="line"></div>
        <textarea type='text' class='appTitle-textarea' name='error_message' title='Error Message'
            required>Local proxy failed</textarea>

        <br><br>
        <div class="containerText">Mode</div>
        <div class="line"></div>
        <select class="appTitle" name="mode">
            <option value="non-blocking">non-blocking</option>
            <option value="blocking">blocking</option>
        </select>
        <br><br>

        <div class="containerText">Search mode</div>
        <div class="line"></div>
        <select class="appTitle" name="search_mode">
            <option value="orders">Orders</option>
            <option value="products">Products</option>
            <option value="customers">Customers</option>
            <option value="notifications">Notifications</option>
        </select>
        <br><br>

        <div class="containerText">Instruction</div>
        <div class="line"></div>
        <select class="appTitle" name="instruction">
            <option value="add_order">Add Order</option>
            <option value="sync_order">Sync Order</option>
            <option value="add_product">Add Product</option>
            <option value="add_variant">Add Variant</option>
        </select>
        <br><br>

        <div class="containerText">Status</div>
        <div class="line"></div>
        <select class="appTitle" name="status">
            <option value="failed">Failed</option>
            <option value="completed">Completed</option>
            <option value="processing">Processing</option>
        </select>
        <br><br>

        <div class="containerText">Enable Retry</div>
        <div class="line"></div>
        <select class="appTitle" name="enable_retry">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
        <br><br>

        <input class='button' type='submit'>
    </form>
</body>

</html>