<?php
/**
 * Created by PhpStorm.
 * User: MAMA
 * Date: 2016/6/20
 * Time: 22:59
 */
//include_once "../../l1comvm/vmlayer.php";

/*

-- --------------------------------------------------------

--
-- 表的结构 `t_f1sym_session`
--

CREATE TABLE IF NOT EXISTS `t_f1sym_session` (
  `sessionid` char(8) NOT NULL,
  `uid` char(20) NOT NULL,
  `lastupdate` int(4) NOT NULL,
  PRIMARY KEY (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `t_f1sym_session`
--

INSERT INTO `t_f1sym_session` (`sessionid`, `uid`, `lastupdate`) VALUES
('KpjEAyCZ', 'UID001', 1466300141);


 -- --------------------------------------------------------

 --
 -- 表的结构 `t_f1sym_account`
 --

 CREATE TABLE IF NOT EXISTS `t_f1sym_account` (
   `uid` char(10) NOT NULL,
   `user` char(20) DEFAULT NULL,
   `nick` char(20) DEFAULT NULL,
   `pwd` char(20) DEFAULT NULL,
   `attribute` char(10) DEFAULT NULL,
   `phone` char(20) DEFAULT NULL,
   `email` char(50) DEFAULT NULL,
   `regdate` date DEFAULT NULL,
   `city` char(10) DEFAULT NULL,
   `backup` text,
   PRIMARY KEY (`uid`)
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

 --
 -- 转存表中的数据 `t_f1sym_account`
 --

 INSERT INTO `t_f1sym_account` (`uid`, `user`, `nick`, `pwd`, `attribute`, `phone`, `email`, `regdate`, `city`, `backup`) VALUES
 ('UID001', 'admin', '爱启用户', 'admin', '管理员', '13912341234', '13912341234@cmcc.com', '2016-05-28', '上海', ''),
 ('UID002', '李四', '老李', 'li_4', '管理员', '13912341234', '13912341234@cmcc.com', '2016-06-17', '上海', ''),
 ('UID003', 'user_01', '用户01', 'user01', '管理员', '13912349901', '13912349901@qq.com', '2016-04-01', '上海', NULL),
 ('UID004', 'user_02', '用户2', 'user02', '用户', '13912349902', '13912349902@qq.com', '2016-05-28', '上海', ''),
 ('UID005', 'user_03', '用户三', 'user03', '用户', '13912349903', '13912349902@qq.com', '2016-05-28', '上海', '');


-- --------------------------------------------------------
--
-- 表的结构 `t_f1sym_authlist`
--

CREATE TABLE IF NOT EXISTS `t_f1sym_authlist` (
  `sid` int(4) NOT NULL AUTO_INCREMENT,
  `uid` char(10) NOT NULL,
  `auth_code` char(20) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `t_f1sym_authlist`
--

INSERT INTO `t_f1sym_authlist` (`sid`, `uid`, `auth_code`) VALUES
(1, 'UID001', 'P_0001'),
(2, 'UID001', 'P_0002'),
(3, 'UID003', 'PG_1111'),
(64, 'UID005', 'P_0002'),
(65, 'UID005', 'P_0004'),
(66, 'UID005', 'P_0012'),
(67, 'UID004', 'P_0008'),
(68, 'UID004', 'P_0009'),
(69, 'UID004', 'P_0010'),
(70, 'UID001', 'P_0003'),
(72, 'UID002', 'P_0004'),
(73, 'UID002', 'P_0010'),
(74, 'UID002', 'P_0012');

-- --------------------------------------------------------

--
-- 表的结构 `t_f1sym_userprofile`
--

CREATE TABLE IF NOT EXISTS `t_f1sym_userprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- 转存表中的数据 `t_f1sym_userprofile`
--

INSERT INTO `t_f1sym_userprofile` (`id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `created_at`, `updated_at`, `flags`) VALUES
(50, 'bxxh2015', 'bxxh2015@sina.cn', '$2y$12$3vo17XiHR8tzfmAsXOK8BeDJsd38ONOSTjbv0C19qbpr2C7IfDggK', '3au2TiBE1NjaP0D0iy9-e9MzFLJ5I7ws', 1442896173, NULL, NULL, '183.193.36.164', 1442896107, 1442896173, 0),
(49, 'linqiu12611', 'linqiu126@sina.cn', '$2y$12$9zRpK4xehj5s/npanxz6O.P1njI5MUsDBB9wskUYJ12cuTWZdrcJq', 'bqjflR9mJOyioXiYhQUGfWjMDPIg-GSJ', 1442894217, NULL, NULL, '183.193.36.164', 1442894194, 1442894217, 0),
(51, 'mfuncloud', 'liuzehong@hotmail.com', '$2y$12$/zjcwitKWqk.hfa.ligqFOtmiHMwProHj.QugIuvYFvFxY7MbY7om', 'k05QvRL9FCgxSv13BcB363dcPOFF2hJA', NULL, NULL, NULL, '101.226.125.122', 1444047832, 1444047832, 0),
(52, 'zjl', 'smdzjl@sina.cn', '$2y$12$pCBD9e0/B0bvwKs6crXA2.pzy606Bn4o19Bzx1r8jdjr1t1nN/jc.', 'GPJwlaHeV0JaMswrLuai0JsW7H8aUjPh', 1444091551, NULL, NULL, '117.135.149.14', 1444091501, 1444091551, 0),
(53, 'shanchuz', 'zsc0905@sina.com', '$2y$12$mlslUwrYelb5nV6DfYot9ORgYGI9YB5.bN/HCMYru6QRn6UrfJsP6', '7VMvRAprvPsYU-Fqt6jDYeLvUzfLzdjF', 1444527288, NULL, NULL, '101.226.125.108', 1444527242, 1444527288, 0);




*/

class classDbiL3apF1sym
{
    //构造函数
    public function __construct()
    {

    }





}

?>