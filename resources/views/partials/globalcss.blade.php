<style>
    #app {
        transition: margin-left .5s;
    }

    /* Header/logo Title */
    .header {
        /* padding: 80px;*/
        text-align: center;
        background: #1abc9c;
        color: white;
    }

    /* Increase the font size of the heading */
    .header h1 {
        font-size: 40px;
    }

    /* Sticky navbar - toggles between relative and fixed, depending on the scroll position. It is positioned relative until a given offset position is met in the viewport - then it "sticks" in place (like position:fixed). The sticky value is not supported in IE or Edge 15 and earlier versions. However, for these versions the navbar will inherit default position */
    .navbar {
        /*overflow: hidden;*/
        background-color: #333;
        color: black;
        position: sticky;
        position: -webkit-sticky;
        top: 0;
        padding:0;
    }

    /* Style the navigation bar links */
    .navbar a {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 14px 20px;
        text-decoration: none;
    }


    /* Right-aligned link */
    .navbar a.right {
        float: right;
    }

    /* Change color on hover */
    .navbar a:hover {
        background-color: #ddd;
        color: black;
    }

    /* Active/current link */
    .navbar a.active {
        background-color: #666;
        color: white;
    }

    /* Column container */
    .principal {  
        display: -ms-flexbox; /* IE10 */
        display: flex;
        -ms-flex-wrap: wrap; /* IE10 */
        flex-wrap: wrap;
    }

    /* Create two unequal columns that sits next to each other */
    /* Sidebar/left column */
    .side {
        -ms-flex: 30%; /* IE10 */
        flex: 30%;
        background-color: #f1f1f1;
        /* padding: 20px;*/
    }

    /* Main column */
    .main {   
        -ms-flex: 70%; /* IE10 */
        flex: 70%;
        background-color: white;
        /* padding: 20px;*/
    }

    /* Fake image, just for this example */
    .fakeimg {
        background-color: #aaa;
        width: 100%;
        /*  padding: 20px;*/
    }

    /* Footer */
    .footer {
        /* padding: 20px;*/
        text-align: center;
        background: #ddd;
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: green;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: white;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    .dropdown-item{
        color: black;
    }
    /*opennav*/
    .buttonNav{box-shadow: 0 6px #999; border-radius: 10px;font-size: 15px;padding: 2px 15px;color:black;display:inline-block;vertical-align:middle;-webkit-transform:perspective(1px) translateZ(0);transform:perspective(1px) translateZ(0);box-shadow:0 0 1px rgba(0,0,0,0);position:relative;overflow:hidden;background:white;-webkit-transition-property:color;transition-property:color;-webkit-transition-duration:.3s;transition-duration:.3s}
    .buttonNav:before{content:"";position:absolute;z-index:-1;top:0;left:0;right:0;bottom:0;background:green;border-radius:100%;-webkit-transform:scale(0);transform:scale(0);-webkit-transition-property:transform;transition-property:transform;-webkit-transition-duration:.3s;transition-duration:.3s;-webkit-transition-timing-function:ease-out;transition-timing-function:ease-out}
    .buttonNav:active,.buttonNav:focus,.buttonNav:hover{color:white}
    .buttonNav:active:before,
    .buttonNav:focus:before,
    .buttonNav:hover:before{-webkit-transform:scale(2);transform:scale(2)}
    /**SIDENAV*/
    .accordion {
        background-color: green;
        color: white;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 25px;
        transition: 0.4s;
    }

    .active  {
        background-color: white;
        color: orange;
    }
    .accordion:hover{
        background-color: white;
        color: darkorange;
    }

    .accordion:after {
        content: '\002B';
        color: orange;
        font-weight: bold;
        float: right;
        margin-left: 5px;
    }

    .active:after {
        content: "\2212";
        color:orange;
    }

    .panelAccordion {
        padding: 0 18px;
        background-color: #21ba45;
        color: white;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.2s ease-out;
    }
    .panelAccordion a {
        color:white;       
    }
    .panelAccordion a:hover {
        color:orange;       
        background-color:white;       
    }
    .btn-group > .btn, .btn-group-vertical > .btn {
        position: unset;
    }
    .btn-group, .btn-group-vertical {
        position: unset;
    }
    /**SIDENAV*/
    /* Responsive layout - when the screen is less than 700px wide, make the two columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 700px) {
        .principal {   
            flex-direction: column;
        }
    }

    /* Responsive layout - when the screen is less than 400px wide, make the navigation links stack on top of each other instead of next to each other */
    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
        .navbar a {
            float: none;
            width: 100%;
        }
    }

</style>