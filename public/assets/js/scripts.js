// function getPageList(totalPages, page, maxlength){
//     function range(start, end){
//         return Array.from(Array(end - start + 1),(_,i) => i + start);
//     }

//     var sideWidth = maxlength < 9 ? 1: 2;
//     var rightWidth =(maxlength - sideWidth * 2 - 3) >> 1;
//     var leftWidth = (maxlength - sideWidth * 2 - 3) >> 1;


//     if(totalPages <= maxlength){
//         return range(1, totalPages);
//     }

//     if(page <= maxlength - sideWidth - 1 - rightWidth){
//         return range(1, maxlength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
//     }

//     if(page >= totalPages - sideWidth - 1 - rightWidth){
//         return range(1, sideWidth).concat(0,range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
//     }

//     return range(1, sideWidth).concat(0,range(page - leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
// }

// $(function(){

//     var numberOfItems = $(".product-refurbish-card-content .refurbish-product-card").length;
//     var limitPerPage =  12;
//     var totalPages = Math.ceil(numberOfItems / limitPerPage );
//     var paginationSize = 7;
//     var currentPage; 

//     function showPage(whichPage){
//         if(whichPage < 1 || whichPage > currentPage) return false;

//         currentPage = whichPage;

           
//         $(".product-refurbish-card-content .refurbish-product-card").hide().slice( (currentPage - 1) * limitPerPage, currentPage * limitPerPage).show() ;

//         $(".pagination li").slice(1 , -1).remove();

//         getPageList(totalPages, currentPage, paginationSize).forEach(item => {
//             $("<li>").addClass("page-items").addClass(item ? "current-page" : "dots").toggleClass("active", item === currentPage).append($("<a>")
//             .addClass("page-link").attr({href: "javascript:void(0)"}).text(item || "...")).insertBefore(".next-page");
//         });

//         $(".previous-page").toggleClass("disable", currentPage === 1);
//         $(".next-page").toggleClass("disable", currentPage === totalPages);
//         return true
//     }

//     $(".pagination").append(
//         $("<li>").addClass("page-items").addClass("previous-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Prev")),
        
//         $("<li>").addClass("page-items").addClass("next-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(1)"}).text("Next")),
//     );


//     $(".product-refurbish-card-content").show();
//     showPage(1);
    

//     $(document).on("click",".pagination li.current-page:not(.active)", function(){
//         return showPage(+$(this).text());
//     });

//     $(".next-page").on("click", function(){
//         return showPage(currentPage + 1);
//     });

// });







// setInterval(function(){
//     level++;

//     if(level >= nbr_img){
//         level = 0;
//     }
//     removeActiveImages();
//     img_slider[level].classList.add('active');
// },3000);




// const carouselContainer = document.querySelector(".carouselContainer");  
//  const slides = document.querySelectorAll('.slides');  
//  const next = document.querySelector('.next-btn');  
//  const prev = document.querySelector('.prev-btn');  
//  let counter = 0 ;  
//  const size = slides[0].clientWidth; 

//  function removeActiveImages(){
//     for(let i = 0 ; i < slides.length; i++){
//         slides[i].classList.remove('activate');
//     }
// }

//  next.addEventListener('click',()=>{  
//    if (counter>=slides.length){
//      counter = 0;
//    }  
//    removeActiveImages();
//    slides[counter].classList.add('activate'); 
//    counter++;  
//  });  
//  prev.addEventListener('click',()=>{  
//    if (counter <= 0){
//     counter = slides.length - 1;
//    } 
//    removeActiveImages();
//    slides[counter].classList.add('activate');
//    counter--;  
//  });  