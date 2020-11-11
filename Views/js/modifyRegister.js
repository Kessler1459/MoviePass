function modifyRoom(id,capacity,ticketPrice,description,cinemaId)
{
   
    document.getElementById("roomId").value = id;
    document.getElementById("modalCapacity").value = capacity;
    document.getElementById("modalTPrice").value = ticketPrice;
    document.getElementById("modalDescription").value = description;
    document.getElementById("cinemaId").value = cinemaId;
      
}

function modifyCinema(id,name,province,city,address)
{

    document.getElementById("modalCineId").value = id;
    document.getElementById("modalName").value = name;
    document.getElementById("modalProvince").value = province;
    document.getElementById("modalCity").value = city;
    document.getElementById("modalAddress").value = address;
       
}