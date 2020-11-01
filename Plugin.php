<?php
/**
 * 评论数据导出到 Valine
 *
 * @package Export2Valine
 * @author 公子
 * @version 0.1.0
 * @link https://imnerd.org
 */
class Export2Valine_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Helper::addAction('export2valine', 'Export2Valine_Action');
        Helper::addPanel(1, 'Export2Valine/panel.php', _t('评论导出'), _t('评论导出'), 'administrator');

        return _t('插件已经激活，请设置插件以正常使用！');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
        Helper::removeAction('export2valine');
        Helper::removePanel(1, 'Export2Valine/panel.php');
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
}