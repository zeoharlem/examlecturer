{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Dynamic Table
                        <span class="tools pull-right">
                            <a class="fa fa-chevron-down" href="javascript:;"></a>
                            <a class="fa fa-cog" href="javascript:;"></a>
                            <a class="fa fa-times" href="javascript:;"></a>
                         </span>
                    </header>
                    <div class="panel-body">
                    <div class="adv-table">
                    <table id="dynamic-table-example" class="display table table-bordered table-striped dataTable" aria-describedby="dynamic-table_info">
                    <thead>
                    <tr role="row"><th class="sorting" role="columnheader" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" style="width: 193px;" aria-label="Rendering engine: activate to sort column ascending">Rendering engine</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" style="width: 253px;" aria-label="Browser: activate to sort column ascending">Browser</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" style="width: 222px;" aria-label="Platform(s): activate to sort column ascending">Platform(s)</th><th class="hidden-phone sorting" role="columnheader" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" style="width: 162px;" aria-label="Engine version: activate to sort column ascending">Engine version</th><th class="hidden-phone sorting_desc" role="columnheader" tabindex="0" aria-controls="dynamic-table" rowspan="1" colspan="1" style="width: 113px;" aria-sort="descending" aria-label="CSS grade: activate to sort column ascending">CSS grade</th></tr>
                    </thead>
                    
                    <tbody role="alert" aria-live="polite" aria-relevant="all"><tr class="gradeX odd">
                        <td class=" ">Trident</td>
                        <td class=" ">Internet
                            Explorer 4.0</td>
                        <td class=" ">Win 95+</td>
                        <td class="center ">4</td>
                        <td class="center ">X</td>
                    </tr></tbody></table>
                    </div>
                    </div>
                </section>
            </div>
{% endblock %}