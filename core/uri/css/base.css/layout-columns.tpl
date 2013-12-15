.row:after { content: ' '; display: block; height: 0; clear: both; 
    visibility: hidden; }

.col-5 { width: 5%; float:left; }
    
.col-10, .col-tenth { width: 10%; float: left; }

.col-15 { width: 15%; float: left; }

.col-8, .col-twelfth { width: 8.3333333333%; float: left; }

.col-16, .col-17, .col-sixth { width: 16.666666666666%; float: left; }

.col-20, .col-fifth { width: 20%; float: left; }

.col-25, .col-fourth { width: 25%; float: left; }

.col-30 { width: 30%; float: left; }

.col-33, .col-34, .col-third { width: 33.333333333333%; float: left; }

.col-35 { width: 35%; float: left; }

.col-38, .col-39, .col-golden-1 { width: 38.19660113%; float: left; } 

.col-40 { width: 40%; float: left; }

.col-41, .col-42 { width: 41.666666666666%; float: left; }

.col-45 { width: 45%; float: left; }

.col-50, .col-half { width: 50%; float: left; }

.col-55 { width: 55%; float: left; }

.col-58, .col-59 { width: 58.33333333333333%; float: left; }

.col-60 { width: 60%; float: left; }

.col-61, .col-62, .col-golden-2 { width: 61.80339887%; float: left; } 

.col-65 { width: 65%; float: left; }

.col-66, .col-67 { width: 66.666666666%; float: left; }

.col-70 { width: 70%; float: left; }

.col-75 { width: 75%; float: left; }

.col-80 { width: 80%; float: left; }

.col-83, .col-84 { width: 83.333333333333%; float: left; }

.col-85 { width: 85%; float: left; }

.col-90 { width: 90%; float: left; }

.col-91, .col-92 { width: 91.66666666666666666%; float: left; }

.col-95 { width: 95%; float: left; }

.col-100 { width: 100%; float: left; }

@media (min-width: 641px) and (max-width: 799px) {
    .small-100 { width: 100%; }
    
    .small-50 { width: 50%; }
}

@media (min-width: 481px) and (max-width: 640px) { /* use only columns of 50% */
    .col-5, .col-10, .col-tenth, .col-15, .col-8, .col-twelfth, .col-16, .col-17, 
        .col-sixth, .col-20, .col-fifth, .col-25, .col-fourth, .col-30, .col-33, 
        .col-34, .col-third, .col-35, .col-38, .col-39, .col-golden-1, .col-40,
        .col-41, .col-42, .col-45, .col-50, .col-half, .col-55, .col-58, .col-59, 
        .col-60, .col-61, .col-62, .col-golden-2, .col-65, .col-66, .col-67, .col-70, 
        .col-75, .col-80, .col-83, .col-84, .col-85, .col-90, .col-91, .col-92, 
        .col-95 { width: 50%; }
        
    .mobile-100, .small-100 { width: 100%; }
        
}

@media (max-width: 480px) { /* use only columns of 100% */
    .col-5, .col-10, .col-tenth, .col-15, .col-8, .col-twelfth, .col-16, .col-17, 
        .col-sixth, .col-20, .col-fifth, .col-25, .col-fourth, .col-30, .col-33, 
        .col-34, .col-third, .col-35, .col-38, .col-39, .col-golden-1, .col-40,
        .col-41, .col-42, .col-45, .col-50, .col-half, .col-55, .col-58, .col-59, 
        .col-60, .col-61, .col-62, .col-golden-2, .col-65, .col-66, .col-67, .col-70, 
        .col-75, .col-80, .col-83, .col-84, .col-85, .col-90, .col-91, .col-92, 
        .col-95 { width: 100%; float: none; }

}
