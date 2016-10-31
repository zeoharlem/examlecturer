<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        
        <meta charset="utf-8">
        <title>School Portal</title>
        <meta content="IE=edge" http-equiv="X-UA-Compatible">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        {{ this.assets.outputCss('prints') }}
        {% block head %}
        {% endblock %}
        <link href="favicon.ico" rel="shortcut icon">
<style type="text/css">
            @media print{
                .table{
                    border-collapse: collapse !important;
                }
                .noprint{
                    display: none !important;
                }
                
                @page {
                    size: landscape;
                }
                
                td{
                    white-space: nowrap;
                    border: 1px solid #aaa;
                    font-size:10px !important;
                }
                
                th.rotates{
                    height: 190px;
                    white-space: nowrap;
                }

                th.rotates > div{
                    transform: translate(25px, 51px)rotate(-90deg);
                    width:10px !important;
                    
                }

                th.rotates > div > span{
    /*                border: 1px solid #ccc;*/
                }
            }
            .table{
                border-collapse: collapse !important;
            }
            td{
                white-space: nowrap;
                border-collapse: collapse !important;
            }
            th{
                background-color: none !important;
            }
            th.rotates{
                height: 190px;
                white-space: nowrap;
            }
            
            th.rotates > div{
                transform: translate(25px, 51px)rotate(-90deg);
                width:10px !important;
            }
            
            th.rotates > div > span{
/*                border: 1px solid #ccc;*/
            }
            body, html{
                background: white !important;
                font-size:10px !important;
            }
            .text-center{
                /*border:1px solid #333 !important;*/
            }
        </style>
</head>
<body>
<section id="main-content">
    <section class="wrapper">
    <!-- page start-->

    <div class="row">
        <div class="col-md-12">
{% block content %}
        
{% endblock %}
        </div>
    </div>
<button class="btn btn-primary noprint" onclick="window.print();">Print Page</button>
</section>
</section>
<script type="text/javascript">
    window.print();
    
</script>
</body>
</html>