<!DOCTYPE html>
<html>

<body>
  <div>
    Hi {{ $name }},
    <br>

    <br>
      Thank You For Registering For E-conclave 2K17!!<br>
    <p style="padding-left: 30px">
      Amount Paid by you is : <br>
      Amount left to be paid before event is : <br><br>

      Event Details are :<br>
    </p>
      <p style="padding-left: 60px">
        Date: 15.September,2017<br>
        Venue: Sinhgad College Campus.<br><br>
      </p>
    <p style="padding-left: 30px">
      Please use the QR-Code for your entry to the event.<br>
      See you at the Event ! Cheers!<br><br>
    </p>

    <img src="{{ $message->embed($pathToFile) }}" align="center">

    Regards,<br>
    Team E-CELL,<br>
    SKNCOE.<br>

  </div>
</body>
</html>



