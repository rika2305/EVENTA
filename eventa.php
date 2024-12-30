<?php
session_start();
if (!isset($_SESSION['username'])) {
    // Redirect back to login if not logged in
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eventa - Concert Events</title>
    <style>
      body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
      }

      header {
        background: url("background.png") no-repeat center center/cover;
        color: white;
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 40px;
        transition: all 0.3s ease-in-out;
      }

      header.scrolled {
        padding: 10px 40px;
        background: rgba(0, 0, 0, 0.8);
      }

      .logo {
        display: flex;
        align-items: center;
      }

      .logo img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 15px;
      }

      .logo h1 {
        margin: 0;
        font-size: 24px;
      }

      nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
      }

      nav ul li {
        margin: 0 15px;
      }

      nav ul li a {
        color: white;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
      }

      nav ul li a:hover {
        color: #f1c40f;
      }

      .content {
        margin-top: 120px;
        width: 90%;
        max-width: 1200px;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
      }

      .lineup {
        flex: 2;
        padding: 20px;
      }

      .lineup h2 {
        text-align: center;
      }

      .event-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        padding: 20px;
      }

      .event {
        border: 1px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        text-align: center;
        padding: 10px;
      }

      .event img {
        width: 100%;
        height: 200px;
        object-fit: cover;
      }

      .ticket-section {
        flex: 1;
        padding: 20px;
        border-left: 1px solid #ccc;
      }

      .ticket-tab {
        margin-bottom: 20px;
        background-color: #f6f3f2;
        padding: 10px;
        border-radius: 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
      }

      .ticket-tab label {
        font-weight: bold;
        font-size: 18px;
      }

      .ticket-tab .arrow {
        font-size: 18px;
      }

      .ticket-options {
        display: none;
        background: #f1f1f1;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
      }

      .ticket-item {
        padding: 10px;
        background: #dbd7d0;
        margin-bottom: 10px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }

      .sold-out {
        color: red;
        font-weight: bold;
      }

      .btn-buy {
        background-color: #27ae60;
        padding: 15px 25px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        text-align: center;
        width: 100%;
        margin-top: 20px;
        cursor: pointer;
      }

      footer {
        background: #d3d3d3;
        text-align: center;
        padding: 10px 0;
        width: 100%;
      }

      .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
      }

      .popup-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        width: 90%;
        max-width: 400px;
        text-align: center;
      }

      .popup-content button {
        margin: 10px;
        padding: 10px 20px;
        border: none;
        background-color: #007bff;
        color: white;
        border-radius: 5px;
        cursor: pointer;
      }

      .popup-content button:hover {
        background-color: #0056b3;
      }
    </style>
    <script>
      function togglePopup(ticketType, price) {
        const popup = document.getElementById("payment-popup");
        popup.style.display = "flex";
        document.getElementById("selected-ticket").value = ticketType;
        document.getElementById("selected-price").value = price;
      }

      function closePopup() {
        document.getElementById("payment-popup").style.display = "none";
      }

      function toggleTicketOptions(optionId) {
        const options = document.getElementById(optionId);
        if (options.style.display === "block") {
          options.style.display = "none";
        } else {
          options.style.display = "block";
        }
      }

      function submitPayment(method) {
        const ticketType = document.getElementById("selected-ticket").value;
        const price = document.getElementById("selected-price").value;

        // Simulate submitting to a database (this would involve a server-side script in a real application)
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "process_payment.php";

        const ticketInput = document.createElement("input");
        ticketInput.type = "hidden";
        ticketInput.name = "ticket_type";
        ticketInput.value = ticketType;
        form.appendChild(ticketInput);

        const priceInput = document.createElement("input");
        priceInput.type = "hidden";
        priceInput.name = "price";
        priceInput.value = price;
        form.appendChild(priceInput);

        const methodInput = document.createElement("input");
        methodInput.type = "hidden";
        methodInput.name = "payment_method";
        methodInput.value = method;
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
      }
    </script>
  </head>

  <body>
    <header>
      <div class="logo">
        <img src="2.png" alt="Eventa Logo" />
        <h1>Eventa</h1>
      </div>
      <nav>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#lineup">Lineup</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </nav>
    </header>

    <div class="content">
      <section class="lineup" id="lineup">
        <h2>Lineup</h2>
        <div class="event-list">
          <div class="event">
            <img src="juicyLuicy.jpg" alt="Juicy Luicy" />
            <h3>JUICY LUICY</h3>
          </div>
          <div class="event">
            <img src="feby-putri.jpg" alt="Feby Putri" />
            <h3>FEBY PUTRI</h3>
          </div>
          <div class="event">
            <img src="hindia.jpg" alt="Hindia" />
            <h3>HINDIA</h3>
          </div>
          <div class="event">
            <img src="tulus.jpg" alt="Tulus" />
            <h3>TULUS</h3>
          </div>
          <div class="event">
            <img src="afgan.jpg" alt="Afgan" />
            <h3>AFGAN</h3>
          </div>
          <div class="event">
            <img src="mahalini.jpg" alt="Mahalini" />
            <h3>MAHALINI</h3>
          </div>
          <div class="event">
            <img src="reality-club.jpg" alt="Reality Club" />
            <h3>REALITY CLUB</h3>
          </div>
        </div>
      </section>

      <section class="ticket-section">
        <h2>Buy Tickets</h2>
        <p><strong>Eventa 2025</strong></p>
        <p><strong>Date:</strong> 17 January 2025</p>
        <p><strong>Time:</strong> 15:00 WIB</p>
        <p><strong>Location:</strong> Batam City, Batam, Riau Islands</p>

        <!-- Ticket VIP Section -->
        <div class="ticket-tab" onclick="toggleTicketOptions('vip-options')">
          <label for="ticket-vip">Tiket VIP:</label>
          <span class="arrow">⮕</span>
        </div>

        <div id="vip-options" class="ticket-options">
          <div class="ticket-item">
            <div>
              <strong>Presale 1 - VIP</strong><br />
              1. Tiket VIP untuk 1 Orang<br />
              2. Tiket sudah termasuk pajak<br />
              3. Tiket belum termasuk platform fee
            </div>
            <div>Rp 165,000</div>

            <button
              onclick="togglePopup('Presale 1 - VIP', 165000)"
              class="btn-buy"
            >
              Buy Now
            </button>
          </div>

          <div class="ticket-item sold-out">
            <div>
              <strong>Early Bird - VIP</strong><br />
              1. Tiket VIP untuk 1 Orang<br />
              2. Tiket sudah termasuk pajak<br />
              3. Tiket belum termasuk platform fee
            </div>
            <div>Rp 155,000 sold out</div>
          </div>
        </div>

        <!-- Ticket Festival Section -->
        <div
          class="ticket-tab"
          onclick="toggleTicketOptions('festival-options')"
        >
          <label for="ticket-festival">Tiket Festival:</label>
          <span class="arrow">⮕</span>
        </div>

        <div id="festival-options" class="ticket-options">
          <div class="ticket-item">
            <div>
              <strong>Presale 1 - Festival</strong><br />
              1. Tiket Festival untuk 1 Orang<br />
              2. Tiket sudah termasuk pajak<br />
              3. Tiket belum termasuk platform fee
            </div>
            <div>Rp 135,000</div>

            <button
              onclick="togglePopup('Presale 1 - Festival', 135000)"
              class="btn-buy"
            >
              Buy Now
            </button>
          </div>

          <div class="ticket-item sold-out">
            <div>
              <strong>Early Bird - Festival</strong><br />
              1. Tiket Festival untuk 1 Orang<br />
              2. Tiket sudah termasuk pajak<br />
              3. Tiket belum termasuk platform fee
            </div>
            <div>Rp 125,000 sold out</div>
          </div>

          <div class="ticket-item sold-out">
            <div>
              <strong>BLIND TICKET - Festival</strong><br />
              1. Tiket Festival untuk 1 Orang<br />
              2. Tiket sudah termasuk pajak<br />
              3. Tiket belum termasuk platform fee
            </div>
            <div>Rp 110,000 sold out</div>
          </div>
        </div>
      </section>
    </div>

    <div id="payment-popup" class="popup">
      <div class="popup-content">
        <h3>Choose Payment Method</h3>
        <button onclick="submitPayment('GoPay')">Pay with GoPay</button>
        <button onclick="submitPayment('QRIS')">Pay with QRIS</button>
        <button onclick="closePopup()">Cancel</button>

        <!-- Hidden inputs to store ticket details -->
        <input type="hidden" id="selected-ticket" />
        <input type="hidden" id="selected-price" />
      </div>
    </div>

    <footer>
      <p>&copy; 2025 Eventa. All Rights Reserved.</p>
    </footer>
  </body>
</html>
