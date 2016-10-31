{% extends "templates/base.volt" %}

{% block head %}
{% endblock %}
{% block content %}
    <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Result View | <strong>{{studentFlow.firstname | capitalize}} {{studentFlow.lastname | capitalize}}</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        <p>&nbsp;</p>
                        <p><a href="{{url('results/createSinglePersonExcelSheet?level='~this.request.getQuery('level')~'&matric='~this.request.getQuery('matric')~'&session='~this.request.getQuery('session'))}}" class="btn btn-primary" target="_blank">Excel</a></p>
                        <p>&nbsp;</p>
                        <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Course Description</th>
                                    <th>Code</th>
                                    <th>Matric Number</th>
                                    <th>Level</th>
                                    <th>Session</th>
                                    <th class="text-center">Units</th>
                                    <th class="text-center">Points</th>
                                    <th class="text-center">C.A</th>
                                    <th class="text-center">Exam</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for keys,values in stackFlow %}
                                <tr>
                                    <td>{{values['title'] | capitalize}}</td>
                                    <td>{{values['code'] | uppercase}}</td>
                                    <td>{{values['matric']}}</td>
                                    <td>{{values['level']}}</td>
                                    <td>{{values['session']}}</td>
                                    <td class="text-center">{{values['units']}}</td>
                                    <td class="text-center">{{values['grade']}}</td>
                                    <td class="text-center">{{values['ca']}}</td>
                                    <td class="text-center">{{values['score']}}</td>
                                </tr>
                                {% endfor %}
                                <tr>
                                    <td class="text-right"><strong>TOTAL</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{totalGrade}}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>TOTAL Units Passed</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalUnitP}}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>TOTAL Units Failed</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalUnitF}}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>TOTAL Units</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center">{{totalUnits}}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>TOTAL Grade Points</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{totalGrade}}</td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                <tr>
                                    <td class="text-right"><strong>TOTAL Weighted Average Points</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"><strong>{{weightedAvr}}</strong></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
{% endblock %}