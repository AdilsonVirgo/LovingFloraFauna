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
    .buttonNav {
        padding: 2px 15px;
        font-size: 15px;
        text-align: center;
        cursor: pointer;
        outline: none;
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 10px;
        box-shadow: 0 6px #999;
    }

    .buttonNav:hover {background-color: #3e8e41}

    .buttonNav:active {
        background-color: #3e8e41;
        box-shadow: 0 3px #666;
        transform: translateY(4px);
    }
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
        background-color: orange;
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