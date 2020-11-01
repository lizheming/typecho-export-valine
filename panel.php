<?php
include_once 'common.php';
include 'header.php';
include 'menu.php';
?>

<div class="main">
  <div class="body container">
    <div class="typecho-page-title">
      <h2><?php _e('评论数据导出'); ?></h2>
    </div>
    <div class="row typecho-page-main" role="form">
      <div id="dbmanager-plugin" class="col-mb-12 col-tb-8 col-tb-offset-2">
        <p>在您点击下面的按钮后，Typecho会创建一个 JSON 文件，供您保存到计算机中。</p>
        <p>在 Leancloud 后台新建应用后，选择 <kbd>存储</kbd>-<kbd>导入导出</kbd>-<kbd>数据导入</kbd>。Class 名称输入“Comment”，数据文件选择刚才导出的 JSON 文件。点击导入按钮即可等待导入成功。</p>
        <p>导入的时间会随着评论数的增加而增加，如果评论数比较多的请耐心等待提示。</p>
        <p>使用过程中如果有问题，请到 <a href="https://github.com/lizheming/typecho-export-valine/issues">Github</a> 提出。</p>
        <form action="<?php $options->index('/action/export2valine?export'); ?>" method="post">
          <ul class="typecho-option typecho-option-submit" id="typecho-option-item-submit-3">
            <li>
              <button type="submit" class="primary"><?php _e('导出 LeanCloud JSON 文件'); ?></button>
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
include 'copyright.php';
include 'common-js.php';
include 'table-js.php';
include 'footer.php';
?>