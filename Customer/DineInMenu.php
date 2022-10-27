<?php session_start(); ?>

<?php

include '../MAIN/Dbconfig.php';

if (isset($_GET['TABLEID'])) {

    $_SESSION['TableId'] = $_GET['TABLEID'];
    $tableId = $_SESSION['TableId'];

} else {

    $tableId = $_SESSION['TableId'];

}


$findBranch = mysqli_query($con, "SELECT brId FROM table_master WHERE tId = '$tableId'");
foreach ($findBranch as $findBranchResult) {
    $BranchId = $_SESSION['BranchId'] = $findBranchResult['brId'];
}


if (isset($_SESSION['TableId']) && isset($_SESSION['BranchId'])) {
} else {

    header("location:https://www.google.com/");
}


function RemoveWhiteSpace($string)
{
    $string = str_replace(' ', '', $string);
    return $string;
}




?>

<?php include '../MAIN/CustHeader.php'; ?>



<!-- <nav class="navbar fixed-bottom navbar-expand-lg ">

        <div class="container-fluid">
            <a class="navbar-brand p-0" href="https://www.facebook.com/themuffinhouseambalathara/" target="_blank"> <i class="lni lni-facebook-filled"></i> </a>
            <a class="navbar-brand p-0" href="https://www.instagram.com/themuffinhouseindia/" target="_blank"> <i class="lni lni-instagram-original"></i> </a>
            <div class="nav-main">
                <div class="mini-div">
                    <img src="./assets/img/Muffin House_Brand Book_New-16.jpg" alt="" class="img-fluid">
                    <button id="myBtn" onclick="play()" class="p-2" data-type="mario" style="opacity: 0;position:absolute;"> </button>
                </div>
            </div>
            <a class="navbar-brand p-0" href="https://wa.me/919544209000" target="_blank"><i class="lni lni-whatsapp"></i> </a>
            <a class="navbar-brand p-0" href="https://twitter.com/themuffinhouse2" target="_blank"> <i class="lni lni-twitter-original"></i> </a>

        </div>

        <audio id="audio" src="./assets/confetti.mp3"></audio>

    </nav> -->




<main id="main">

    <!-- ======= Hero Section ======= -->
    <section id="hero">

        <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" style="background-image: url(../Image\ slide\ 2.jpg);">
                    <div class="carousel-content">

                    </div>
                </div>
                <div class="carousel-item" style="background-image: url(../Image\ slide\ 3.jpg);">
                    <div class="carousel-content">
                        <h2>BAKING <br> YOU <br> HAPPY</h2>
                    </div>
                </div>
                <div class="carousel-item" style="background-image: url(../Image\ slide\ 4.jpg);">
                    <div class="carousel-content">
                        <h2>BAKING <br> YOU <br> HAPPY</h2>
                    </div>
                </div>
            </div>

            <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

        </div>

    </section>




    <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
        <div class="container-fluid p-3">


            <div class="search-div">
                <span> <i class="lni lni-search-alt"></i> </span>
                <input type="text" class="form-control quicksearch shadow-none" placeholder="Search Your Food">
            </div>

            <div class="row">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="menu-flters" class="d-flex">
                        <div>
                            <li data-filter="*" id="all" class="filter-active"> <img src="../All.jpg" class="img-fluid" alt=""> </li>
                            <span class="d-flex justify-content-center">All</span>
                        </div>

                        <?php
                        $findAllCategories = mysqli_query($con, "SELECT c.categoryName,c.categoryImage FROM category_master c INNER JOIN product_master p ON c.catId = p.catId INNER JOIN branch_master b ON p.brId = b.brId WHERE b.brId = '$BranchId' GROUP BY c.catId;");
                        foreach ($findAllCategories as $categoryResults) {
                            $CatName =  $categoryResults['categoryName'];
                        ?>
                            <div>
                                <li id="<?php echo $categoryResults['categoryName'] ?>_category" data-filter=".filter-<?php echo RemoveWhiteSpace($CatName); ?>"> <img src="../CATEGORY/<?php echo $categoryResults['categoryImage'] ?>" class="img-fluid" alt=""> </li>
                                <span class="d-block"> <?= $categoryResults['categoryName'] ?> </span>
                            </div>

                        <?php
                        }

                        ?>
                    </ul>
                </div>
            </div>

            <div class="row menu-container p-0 mt-3 ">




                <?php

                $findAllProducts = mysqli_query($con, "SELECT * FROM product_master p INNER JOIN category_master c ON p.catId = c.catId WHERE p.brId = '$BranchId'");
                foreach ($findAllProducts as $ProductResults) {
                    $categoryName = $ProductResults['categoryName'];
                ?>

                    <div class="col-lg-6 menu-item filter-<?php echo RemoveWhiteSpace($categoryName); ?>">
                        <div class="individual-item d-flex py-3 justify-content-between align-items-end ">
                            <div class="contentside">
                                <div class="menu-content mb-3">
                                    <h5> <?= $ProductResults['productName'] ?> </h5>
                                </div>
                                <div class="menu-ingredients">
                                    <h6>&#8377; <?= number_format($ProductResults['productPrice'])  ?></h6>
                                    <!-- <span class=""><i class="lni lni-alarm-clock pe-1 "></i> 15 Min </span> -->
                                    <span class=""> <?= $ProductResults['productMini'] ?></span>
                                </div>
                            </div>
                            <div class="buttonside">
                                <div class="d-flex justify-content-end AddButton">
                                    <button type="button" class="btn btn-decrement" value="<?= $ProductResults['productName'] ?>">-</button>
                                    <input type="number" id="<?= $ProductResults['productName'] ?>_price" class="form-control" value="<?= intval($ProductResults['productPrice']) ?>" hidden>
                                    <input type="text" id="<?= $ProductResults['productName'] ?>" class="form-control qtyvalue text-center px-0" value="0">
                                    <button type="button" class="btn btn-increment" value="<?= $ProductResults['productName'] ?>">+</button>
                                </div>
                            </div>
                        </div>
                    </div>


                <?php
                }

                ?>




            </div>

        </div>
    </section>
    <!-- End Menu Section -->




    <footer id="footer">
        <div class="container mb-3">

            <div class="footer-img text-center mb-5">
                <img src="../muffinhouse.jpg " class="img-fluid " alt=" ">
            </div>

            <p class="">Baking You Happy is just not an idea but a commitment to what Muffin House stands for - its values, its brand personality and its brand promise. It sums up the essence of our existance.</p>

            <div class="copyright">
                Designed By <strong><span>Techstas Info Solutions</span></strong>. All Rights Reserved
            </div>

            <section class="fill mb-4">
                <h1> &nbsp; </h1>
            </section>

        </div>
    </footer>

    <div class="bottomDiv">
        <div class="AddtoCart">
            <div class="d-flex justify-content-between">
                <div>
                    <p> <span id="Totalqty"> 0 </span> items</p>
                    <h6>₹ <span id="TotalSum"> 0 </span> </h6>
                </div>
                <div class="">
                    <button id="ButtonNext" class="btn text-white"> <strong>Next <i class='bx bxs-right-arrow'></i> </strong> </button>
                </div>
            </div>
        </div>
    </div>



</main>
<!-- End #main -->


<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.js"></script>

<!-- Template Main JS File -->
<script src="../JS/main.js"></script>



<script>
    $('#ButtonNext').click(function() {
        console.log(x);
        ArrayData = x;
        $.ajax({
            type: "POST",
            url: "DineInOperations.php",
            data: {
                ArrayData: ArrayData
            },
            success: function(data) {
                console.log(data);
                var response = JSON.parse(data);
                if (response.AddCart == "2") {
                    console.log("error occured");
                } else if (response.AddCart == "1") {
                    location.href = "DineInCart.php";
                }
            },
        });
    });
</script>


<script>
    /////////////////////////////CART FUNCTIONS//////////////////////////////
    let x = [];
    $('.btn-increment').click(function() {
        var GetId = $(this).val();
        var Price = GetId + '_price';
        var Price = document.getElementById(GetId + '_price').value;
        var Oldvalue = parseInt(document.getElementById(GetId).value);
        var NewValue = Oldvalue + 1;
        document.getElementById(GetId).value = NewValue;
        AddItem(GetId, Price, NewValue);
        ShowJson();
        $('#Totalqty').text(FindQty(x));
        $('#TotalSum').text(FindTotal(x));
        ShowPanel();

    });

    $('.btn-decrement').click(function() {
        var GetId = $(this).val();
        var Price = document.getElementById(GetId + '_price').value;
        var Oldvalue = parseInt(document.getElementById(GetId).value);
        if (Oldvalue > 0) {
            var NewValue = Oldvalue - 1;
            RemoveItem(GetId, Price, NewValue);
        } else {
            NewValue = 0;
        }
        document.getElementById(GetId).value = NewValue;
        ShowJson();
        $('#Totalqty').text(FindQty(x));
        $('#TotalSum').text(FindTotal(x));
        ShowPanel();
    });
</script>


<script>
    /////////////////////////////INTERNAL FUNCTIONS//////////////////////////////

    function AddItem(product, price, qty) {
        const exist = x.find(([pro]) => pro === product);
        if (exist) {
            // Update the value
            ++exist[2];
            //console.log("qty updated");
            //console.log(x);
        } else {
            // Add a new entry
            x.push([product, price, qty]);
            //console.log("product added");
            //console.log(x);
        }
    }

    function RemoveItem(product, price, qty) {
        const exist = x.find(([pro]) => pro === product);
        if (exist) {
            // Update the value
            --exist[2];
            //console.log("qty updated");
            //console.log(x);
        } else {
            // Add a new entry
            //x.push([product, price, qty]);
            //console.log("product added");
            //console.log(x);
        }
    }

    function ShowJson() {
        var NewArray = JSON.stringify(x);
        console.log(NewArray);
    }

    function FindTotal(array) {
        return array.reduce((prev, curr) => prev + (curr[1] * curr[2]), 0);
    }

    function FindQty(array) {
        return array.reduce((prev, curr) => prev + curr[2], 0);
    }

    function ShowPanel() {
        if (FindQty(x) > 0) {
            $('.bottomDiv').show();
        } else if (FindQty(x) == 0) {
            $('.bottomDiv').hide();
        }
    }
</script>


<script>
    function pop(e) {
        let amount = 1;
        switch (e.target.dataset.type) {
            case 'shadow':
            case 'line':
                amount = 1;
                break;
        }
        // Quick check if user clicked the button using a keyboard
        const bbox = e.target.getBoundingClientRect();
        const x = bbox.left + bbox.width / 2;
        const y = bbox.top + bbox.height / 2;
        if (e.clientX === 0 && e.clientY === 0) {

            for (let i = 0; i < 1; i++) {
                // We call the function createParticle 30 times
                // We pass the coordinates of the button for x & y values
                createParticle(x, y, e.target.dataset.type);
            }
        } else {
            for (let i = 0; i < amount; i++) {
                createParticle(x, y, e.target.dataset.type);
            }
        }

    }

    function createParticle(x, y, type) {
        const particle = document.createElement('particle');
        document.body.appendChild(particle);
        //let width = Math.floor(Math.random() * 30 + 8);
        let width = 50;
        let height = width;
        //let destinationX = (Math.random() - 0.5) * 300;
        let destinationX = (1) * 0
        let destinationY = (-1) * 500;
        let rotation = 0;
        let delay = 200;
        //let rotation = Math.random() * 520;
        //let delay = Math.random() * 200;

        switch (type) {

            case 'mario':
                particle.innerHTML = ['<h1 style="font-weight:700;color:#d94042">BAKING <br> <span style="color:#67c7c0"> YOU </span> <br> HAPPY</h1>'][Math.floor(Math.random() * 1)];
                particle.style.fontSize = `10px`;
                width = height = 'auto';
                //particle.style.backgroundImage = 'url(https://s3-us-west-2.amazonaws.com/s.cdpn.io/127738/mario-face.png)';
                break;

        }

        particle.style.width = `${width}px`;
        particle.style.height = `${height}px`;
        const animation = particle.animate([{
            transform: `translate(-50%, -50%) translate(${x}px, ${y}px) rotate(0deg)`,
            opacity: 1
        }, {
            transform: `translate(-50%, -50%) translate(${x + destinationX}px, ${y + destinationY}px) rotate(${rotation}deg)`,
            opacity: 0
        }], {
            duration: Math.random() * 1000 + 5000,
            easing: 'cubic-bezier(0, .9, .57, 1)',
            delay: delay
        });
        animation.onfinish = removeParticle;
    }

    function removeParticle(e) {
        e.srcElement.effect.target.remove();
    }


    if (document.body.animate) {

        const element = document.getElementById("myBtn");

        element.addEventListener("click", pop);
    }

    document.querySelector("#myBtn").addEventListener("click", function(e) {
        party.confetti(this);
    });
    party.confetti(runButton, {
        count: party.variation.range(60, 70),
    });

    function play() {
        var audio = document.getElementById("audio");
        audio.play();
    }
</script>

<script>
    $(document).ready(function() {


        // quick search regex
        var qsRegex;

        // init Isotope
        var $container = $('.menu-container').isotope({
            itemSelector: '.menu-item',
            layoutMode: 'fitRows',
            filter: function() {
                return qsRegex ? $(this).text().match(qsRegex) : true;
            }
        });

        // use value of search field to filter
        var $quicksearch = $('.quicksearch').keyup(debounce(function() {
            qsRegex = new RegExp($quicksearch.val(), 'gi');
            $container.isotope();
        }));



        // search - debounce so filtering doesn't happen every millisecond
        function debounce(fn, threshold) {
            var timeout;
            return function debounced() {
                if (timeout) {
                    clearTimeout(timeout);
                }

                function delayed() {
                    fn();
                    timeout = null;
                }
                setTimeout(delayed, threshold || 200);
            }
        }

    });
</script>



<!-- footer -->

<?php

include '../MAIN/Footer.php';

?>