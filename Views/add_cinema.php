<main class="container">
    <h1>New cinema</h1>
    <form action="<?php echo FRONT_ROOT ?>Cinema/add" method="post" class="form-center">
        <div class="form-group text-center">
            <label for="name"><span>Name</span></label>
            <input type="text" name="name" id="name" class="input-cinema" required>
            <label for="address"><span>Address</span></label>
            <input type="address" name="address" id="address" class="input-cinema" required>
            <label for="maxCapacity"><span>Max capacity</span></label>
            <input type="number" name="maxCapacity" id="maxCapacity" class="input-cinema" required>
            <label for="ticketPrice"><span>Ticket Price</span></label>
            <input type="number" step="0.01" name="ticketPrice" id="ticketPrice" class="input-cinema" required>
        </div>
        <button class="submit button-a" type="submit">Register</button>
    </form>
</main>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script src="<?php echo JS_PATH ?>bootstrap.js"></script>