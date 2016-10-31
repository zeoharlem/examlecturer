
    <div class="col-sm-12">
                    <?php if (isset($carryover)) { ?>
                    <section class="panel">
                        <header class="panel-heading">
                            <strong>Students Carry Over</strong>
                            <span class="tools pull-right">
                                <a href="javascript:;" class="fa fa-chevron-down"></a>
                                <a href="javascript:;" class="fa fa-cog"></a>
                                <a href="javascript:;" class="fa fa-times"></a>
                             </span>
                        </header>
                        <div class="panel-body">
                        <form method="post" action="<?php echo $this->url->get('carryover/postover'); ?>">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="border:1px solid #ddd;">Matric Number</th>
                                    <th style="border:1px solid #ddd;">Code</th>
                                    <th style="border:1px solid #ddd;">Course Description</th>
                                    <th style="border:1px solid #ddd;">Level</th>
                                    <th style="border:1px solid #ddd;">Semester</th>
                                    <th style="border:1px solid #ddd;">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($carryover as $keys => $values) { ?>
                                <tr>
                                    <td><?php echo $keys + 1; ?></td>
                                    <td style="border:1px solid #ddd;"><?php echo $values->matric; ?></td>
                                    <td style="border:1px solid #ddd;"><?php echo Phalcon\Text::upper($values->code); ?></td>
                                    <td style="border:1px solid #ddd;"><?php echo ucwords($values->title); ?></td>
                                    <td style="border:1px solid #ddd;"><?php echo $values->level; ?></td>
                                    <td style="border:1px solid #ddd;"><?php echo $values->semester; ?></td>
                                    <td style="border:1px solid #ddd;"><div class="col-lg-2">
                                        <input type="hidden" name="matric[]" value="<?php echo $values->matric; ?>" />
                                        <input type="hidden" name="course[]" value="<?php echo $values->code; ?>" />
                                        <input type="hidden" name="creg_id[]" value="<?php echo $values->creg_id; ?>" />
                                        <input type="text" class="form-control" maxlength="2" name="ca[]" /></div>
                                        <div class="col-lg-2">
                                        <input type="text" class="form-control" maxlength="2" name="exam[]" /></div>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tr style="border:1px solid #ddd;">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    <button class="btn btn-primary"><strong>Upload</strong></button>
                                    <button class="btn btn-success"><strong>Reset</strong></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>    
                        </div>
                    </section>
                
                <?php } else { ?>
                    <div class="alert alert-danger"><strong>No Carry Over Registration</strong></div>
                 <?php } ?>
    </div>
