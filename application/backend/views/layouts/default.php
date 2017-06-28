<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= isset($template['title']) ? $template['title'] : NULL ?></title>
        <?= isset($template['metadata']) ? $template['metadata'] : NULL ?>
        <?= isset($template['asset']) ? $template['asset'] : NULL ?>
        <!-- icon page -->
        <? isset($icon) ? $icon : NULL ?>
        <!-- Core CSS - Include with every page -->
        <? isset($css) ? implode($css) : NULL ?>
        <? isset($_css) ? implode($_css) : NULL ?>
        <!-- Core Scripts - Include with every page -->
        <? isset($js) ? implode($js) : NULL ?>
        <? isset($_js) ? implode($_js) : NULL ?>
    </head>
    <body>
        <div id="wrapper">
            <?= $this->load->view('common/header', NULL, TRUE) ?>
            <?= ''//$this->load->view('common/menu', NULL, TRUE) ?>
            <div id="page-wrapper">
                <?= isset($template['body']) ? $template['body'] : NULL ?>
            </div>
            <!-- /#page-wrapper -->
            <?= ''//$this->load->view('common/footer', NULL, TRUE) ?>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
    </body>
</html>
