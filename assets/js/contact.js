function del(elem_id) 
{
  

    Swal.fire({
      icon: 'warning',
        title: 'Are you sure you want to delete this record?',
        showDenyButton: false,
        showCancelButton: true,
        confirmButtonText: 'Yes'
    }).then((result) => {
      
      if (result.isConfirmed) {

        //var userId = $(this).attr('data-id');

        // Ajax config
      $.ajax({
            type: "POST", //we are using GET method to get data from server side
            url: 'New_Customer.php', // get the route value
            data: {delete_customer:elem_id}, //set data
            beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                
            },
            success: function (response) {//once the request successfully process to the server side it will return result here
                //all();
                var response = JSON.parse(response)
                console.log(response)
                if(response.status == 'OK')
                  Swal.fire('Success.', response.desc, 'success')
                else
                  Swal.fire('Failure.', response.desc, 'warning')
            }
        });

        
      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }
    });
}

