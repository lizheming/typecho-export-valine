<?php

class Export2Valine_Action extends Typecho_Widget implements Widget_Interface_Do
{
  /**
   * 导出 JSON
   *
   * @access public
   * @return void
   */
  public function doExport() {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $comment_table = $prefix . 'comments';
    $content_table = $prefix . 'contents';

    //获取到所有的文章，并创建文章 id => url 的哈希表
    $contentHash = array();
    $sql = "SELECT * FROM {$content_table} WHERE `type` in ('post','page')";
    $tpContents = $db->fetchAll($db->query($sql));
    foreach($tpContents as $content) {
      $contentHash[$content["cid"]] = $content["slug"];
    }

    //获取到所有的评论，并创建评论 ID 的父子哈希表，根据哈希表获取最终的根节点 ID
    $commentHash = array();
    $sql = "SELECT * FROM {$comment_table} WHERE `status` != 'spam'";
    $tpComments = $db->fetchAll($db->query($sql));
    foreach($tpComments as $comment) {
      if($comment["parent"] == 0) {
        continue;
      }
      $commentHash[$comment["coid"]] = $comment["parent"];
    }
    $this->commentHash = $commentHash;
    
    $results = array();
    foreach($tpComments as $comment) {
      $slug = $contentHash[$comment["cid"]];
      $time = date("Y-m-d\TH:i:s.000\Z", $comment["created"]);

      $arr = array(
        "objectId" => md5($comment["coid"]),
        "QQAvatar" => "",
        "comment" => $comment["text"],
        "insertedAct" => array(
          "__type" => "Date",
          "iso" => $time
        ),
        "createdAt" => $time,
        "updatedAt" => $time,
        "ip" => $comment["ip"],
        "link" => $comment["url"],
        "mail" => $comment["mail"],
        "nick" => $comment["author"],
        "ua" => $comment["agent"],
        "url" => "/{$slug}.html"
      );

      if($comment["parent"]) {
        $arr["pid"] = md5($comment["parent"]);
        $arr["rid"] = md5($this->getRootId($comment["coid"]));
      }

      $results[] = $arr;
    }
    
    // 备份文件名
    $fileName = 'valine.' . date('Y-m-d') . '.json';
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename=' . $fileName);
    echo json_encode( array("results" => $results) );
  }

  private function getRootId($id) {
    $parentId = $this->commentHash[$id];
    if(!$parentId) {
      return $id;
    }

    return $this->getRootId($parentId);
  }

  /**
   * 绑定动作
   *
   * @access public
   * @return void
   */
  public function action() {
    $this->widget('Widget_User')->pass('administrator');
    $this->on($this->request->is('export'))->doExport();
  }
}
