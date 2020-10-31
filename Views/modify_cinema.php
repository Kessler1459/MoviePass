<main class="container">
    <h1>Modify cinema</h1>
    <form class="form-center" action="<?php echo FRONT_ROOT ?>Cinema/modify" method="post">
    <div class="form-group text-center">
        <label for="name">
            <span>Name</span>
        </label>
        <input type="text" class="input-cinema" name="name" value=" <?php echo $cinema->getName() ?>" id="name" required>

        <input type="hidden" class="input-cinema" value=<?php echo $cinema->getId() ?> name="id">

        <label for="address">
            <span>Address</span>
        </label>
        <input type="address" class="input-cinema" name="address" id="address" value=" <?php echo $cinema->getAddress() ?>" required>


        <label for="maxCapacity">
            <span>Max capacity</span>
        </label>
        <input type="number" class="input-cinema" name="maxCapacity" id="maxCapacity" value=<?php echo $cinema->getMaxCapacity() ?> required>


        <label for="ticketPrice">
            <span>Ticket Price</span>
        </label>
        <input type="number" class="input-cinema" step="0.01" name="ticketPrice" id="ticketPrice" value=<?php echo $cinema->getTicketPrice() ?> required>
        </div>
        <button class="submit button-a" type="submit">Ok</button>
    </form>
</main>