<!-- Start Footer -->
<?php
     require_once('admin/conn.php'); //connect to database infile conn.php

     $query = "SELECT * FROM categories ORDER BY Category_ID ASC;";
 
     $result = mysqli_query($link,$query);/* dùng để chạy câu lệnh đó trong mysql*/
?>
<footer class="bg-dark" id="tempaltemo_footer">
    <div class="container">
        <div class="row">

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-success border-bottom pb-3 border-light logo">Selling Woods</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li>
                        <i class="fas fa-map-marker-alt fa-fw"></i>
                        20 Cong Hoa, Ward 12, Tan Binh, HCMC
                    </li>
                    <li>
                        <i class="fa fa-phone fa-fw"></i>
                        <a class="text-decoration-none" href="">091900200có</a>
                    </li>
                    <li>
                        <i class="fa fa-envelope fa-fw"></i>
                        <a class="text-decoration-none" href="">Contact@Phat.com</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Type of products</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <?php 
                        while ($row = mysqli_fetch_array($result)){
                    ?>  
                            <li><a class="text-decoration-none" href="#"><?php echo $row['Category_Name']; ?></a></li>               
                    <?php
                        }
                    ?>
                </ul>
            </div>

            <div class="col-md-4 pt-5">
                <h2 class="h2 text-light border-bottom pb-3 border-light">Further Info</h2>
                <ul class="list-unstyled text-light footer-link-list">
                    <li><a class="text-decoration-none" href="{{url('/')}}">Home</a></li>
                    <li><a class="text-decoration-none" href="{{url('about')}}">About Us</a></li>
                    <li><a class="text-decoration-none" href="{{url('contact')}}">Contact</a></li>
                </ul>
            </div>

        </div>

        <div class="row text-light mb-4">
            <div class="col-12 mb-3">
                <div class="w-100 my-3 border-top border-light"></div>
            </div>
            <div class="col-auto me-auto">
                <ul class="list-inline text-left footer-icons">
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="http://facebook.com/"><i
                                class="fab fa-facebook-f fa-lg fa-fw"></i></a>
                    </li>
                    <li class="list-inline-item border border-light rounded-circle text-center">
                        <a class="text-light text-decoration-none" target="_blank" href="http://github.com/"><i
                                class="fab fa-github fa-lg fa-fw"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                    <p class="text-left text-light">
                        Copyright &copy; 2021 Company Name
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- End Footer -->