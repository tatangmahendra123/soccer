$(document).ready(function(){     

   $(document).on('click', '.lihat_data', function(){  
           var detail_pemain = $(this).attr("id_user");  
           $.ajax({  
                url:"pemain.php",  
                method:"post",  
                data:{detail_pemain:detail_pemain},  
                success:function(data){  
                     $('#detail_pemain').html(data);  
                     $('#confirm-detail').modal("show");  
               }  
                });  
           });            
  });