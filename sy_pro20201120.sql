/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : sy_pro

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 20/11/2020 16:36:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '登录账号名',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '甲方公司名称',
  `contacts` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '甲方联系人',
  `contacts_mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '联系人电话',
  `contacts_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '联系人邮箱',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '公司地址',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号码（一般为总机号）',
  `plan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '方案',
  `topology_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '拓扑图url',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '客户状态-状态/10正常/20即将到期/90删除',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间/账号创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '修改时间/用户资料修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `mobile`(`mobile`) USING BTREE,
  INDEX `company`(`company`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1008 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '客户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1001, 'admin', '4297f44b13955235245b2497399d7a93', '上海双于通信有限公司', '王建刚', '18621324504', '604666621@qq.com', '上海市普陀区', '021-23333333', 'SDWAN', 'upload/5fb48fe9451b5160566884115958.png', '备注', 10, '2020-07-17 06:51:58', '2020-11-18 03:07:21');
INSERT INTO `customer` VALUES (1002, 'lanbei', '4297f44b13955235245b2497399d7a93', '蓝贝酒业集团有限公司', '陈志松', '13903155316', '邮箱', '河北省唐山市滦州市日月潭道6号', '0315-7386836', 'SDWAN', 'https://xxx.xxx.xxx', '备注', 10, '2020-07-17 06:51:58', '2020-07-31 01:28:09');
INSERT INTO `customer` VALUES (1003, '1234444', '4297f44b13955235245b2497399d7a93', '123123', '213123', '21321', '123123@qq.com', '123', '123321', '123', 'C:\\Windows\\php2999.tmp', '12312321', 10, '2020-11-17 06:29:05', '2020-11-17 09:42:22');
INSERT INTO `customer` VALUES (1004, '123', '65ded5353c5ee48d0b7d48c591b8f430', '132', '132', '123', '123123@qq.com', '132', '132', '132', '', '123', 10, '2020-11-17 06:37:17', '2020-11-17 06:37:17');
INSERT INTO `customer` VALUES (1005, 'wang', '4297f44b13955235245b2497399d7a93', '123132', '123132', '123132', '132132@qq.com', '132132', '132132', '123', 'upload/5fb48fdba5982160566882759613.png', '121111', 90, '2020-11-17 06:38:03', '2020-11-18 03:07:07');
INSERT INTO `customer` VALUES (1006, '9999', '4297f44b13955235245b2497399d7a93', '12312311', '321321', '321', '123123@qq.com', '23', '312321', '12321', '', '1231321', 10, '2020-11-17 09:51:49', '2020-11-17 09:51:49');
INSERT INTO `customer` VALUES (1007, '8888', '4297f44b13955235245b2497399d7a93', '132', '132', '132', '132132@qq.com', '132', '132', '123', 'upload/5fb48ff87a9d3160566885621118.png', '132', 90, '2020-11-17 09:52:36', '2020-11-18 03:07:36');

-- ----------------------------
-- Table structure for customer_product
-- ----------------------------
DROP TABLE IF EXISTS `customer_product`;
CREATE TABLE `customer_product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '用户id',
  `pid` int(11) NOT NULL COMMENT '产品id',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '自定义的名字',
  `delay` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '延迟',
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '路由',
  `flow` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '流量图url',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态 默认10/已删除90',
  `end_at` timestamp(0) NULL DEFAULT NULL COMMENT '产品到期时间',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '开始时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `pid`(`pid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1007 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户产品关联表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_product
-- ----------------------------
INSERT INTO `customer_product` VALUES (1002, 1001, 1002, '自定义的名字2', '10ms', 'http://xxxxxx', 'http://mrtg.syctnet.com:189/graph_image2.php?action=view&local_graph_id=2929&rra_id=6', '备注信息', 10, '2021-03-10 05:11:08', '2020-08-06 06:40:45', '2020-08-06 06:41:06');
INSERT INTO `customer_product` VALUES (1003, 1001, 1003, '自定义的名字3', '10ms', 'http://xxxxxx', 'http://mrtg.syctnet.com:189/graph_image2.php?action=view&local_graph_id=2929&rra_id=6', '备注信息', 10, '2021-03-10 00:00:00', '2020-08-06 06:40:45', '2020-08-06 06:41:06');
INSERT INTO `customer_product` VALUES (1005, 1001, 1001, '', '1111', '222', '3333', '4444', 10, '2020-10-28 00:00:00', '2020-11-20 14:56:56', NULL);
INSERT INTO `customer_product` VALUES (1006, 1001, 1001, '', '123', '123', '213', '123', 10, '2020-10-30 00:00:00', '2020-11-20 14:57:53', NULL);

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `per_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '权限名',
  `per_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'url',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态/10正常/90删除',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `per_name`(`per_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1041 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '权限表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1001, '用户列表页', 'App\\Http\\Controllers\\Admin\\UserController@index', 10);
INSERT INTO `permission` VALUES (1002, '用户添加页', 'App\\Http\\Controllers\\Admin\\UserController@add', 10);
INSERT INTO `permission` VALUES (1003, '用户添加', 'App\\Http\\Controllers\\Admin\\UserController@create', 10);
INSERT INTO `permission` VALUES (1004, '用户删除', 'App\\Http\\Controllers\\Admin\\UserController@delete', 10);
INSERT INTO `permission` VALUES (1005, '用户修改页', 'App\\Http\\Controllers\\Admin\\UserController@edit', 10);
INSERT INTO `permission` VALUES (1006, '用户修改', 'App\\Http\\Controllers\\Admin\\UserController@update', 10);
INSERT INTO `permission` VALUES (1007, '分配角色页', 'App\\Http\\Controllers\\Admin\\UserController@distributePage', 10);
INSERT INTO `permission` VALUES (1008, '分配角色', 'App\\Http\\Controllers\\Admin\\UserController@distribute', 10);
INSERT INTO `permission` VALUES (1009, '角色列表页', 'App\\Http\\Controllers\\Admin\\RoleController@index', 10);
INSERT INTO `permission` VALUES (1010, '角色添加页', 'App\\Http\\Controllers\\Admin\\RoleController@add', 10);
INSERT INTO `permission` VALUES (1011, '角色添加', 'App\\Http\\Controllers\\Admin\\RoleController@create', 10);
INSERT INTO `permission` VALUES (1012, '角色删除', 'App\\Http\\Controllers\\Admin\\RoleController@delete', 10);
INSERT INTO `permission` VALUES (1013, '角色修改页', 'App\\Http\\Controllers\\Admin\\RoleController@edit', 10);
INSERT INTO `permission` VALUES (1014, '角色修改', 'App\\Http\\Controllers\\Admin\\RoleController@update', 10);
INSERT INTO `permission` VALUES (1015, '角色授权页', 'App\\Http\\Controllers\\Admin\\RoleController@auth', 10);
INSERT INTO `permission` VALUES (1016, '角色授权', 'App\\Http\\Controllers\\Admin\\RoleController@doAuth', 10);
INSERT INTO `permission` VALUES (1017, '权限列表页', 'App\\Http\\Controllers\\Admin\\PermissionController@index', 10);
INSERT INTO `permission` VALUES (1018, '权限添加页', 'App\\Http\\Controllers\\Admin\\PermissionController@add', 10);
INSERT INTO `permission` VALUES (1019, '权限添加', 'App\\Http\\Controllers\\Admin\\PermissionController@create', 10);
INSERT INTO `permission` VALUES (1020, '权限删除', 'App\\Http\\Controllers\\Admin\\PermissionController@delete', 10);
INSERT INTO `permission` VALUES (1021, '权限修改页', 'App\\Http\\Controllers\\Admin\\PermissionController@edit', 10);
INSERT INTO `permission` VALUES (1022, '权限修改', 'App\\Http\\Controllers\\Admin\\PermissionController@update', 10);
INSERT INTO `permission` VALUES (1023, '产品列表', 'App\\Http\\Controllers\\Admin\\ProductController@index', 10);
INSERT INTO `permission` VALUES (1024, '产品添加页', 'App\\Http\\Controllers\\Admin\\ProductController@add', 10);
INSERT INTO `permission` VALUES (1025, '产品添加', 'App\\Http\\Controllers\\Admin\\ProductController@create', 10);
INSERT INTO `permission` VALUES (1026, '产品删除', 'App\\Http\\Controllers\\Admin\\ProductController@delete', 10);
INSERT INTO `permission` VALUES (1027, '产品修改页', 'App\\Http\\Controllers\\Admin\\ProductController@edit', 10);
INSERT INTO `permission` VALUES (1028, '产品修改', 'App\\Http\\Controllers\\Admin\\ProductController@update', 10);
INSERT INTO `permission` VALUES (1029, '客户列表页', 'App\\Http\\Controllers\\Admin\\CustomerController@index', 10);
INSERT INTO `permission` VALUES (1030, '客户添加页', 'App\\Http\\Controllers\\Admin\\CustomerController@add', 10);
INSERT INTO `permission` VALUES (1031, '客户添加', 'App\\Http\\Controllers\\Admin\\CustomerController@create', 10);
INSERT INTO `permission` VALUES (1032, '客户删除', 'App\\Http\\Controllers\\Admin\\CustomerController@delete', 10);
INSERT INTO `permission` VALUES (1033, '客户修改页', 'App\\Http\\Controllers\\Admin\\CustomerController@edit', 10);
INSERT INTO `permission` VALUES (1034, '客户修改', 'App\\Http\\Controllers\\Admin\\CustomerController@update', 10);
INSERT INTO `permission` VALUES (1035, '客户已购产品', 'App\\Http\\Controllers\\Admin\\CustomerController@purchased', 10);
INSERT INTO `permission` VALUES (1036, '添加已购产品', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedAdd', 10);
INSERT INTO `permission` VALUES (1037, '客户已购产品修改页', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedEdit', 10);
INSERT INTO `permission` VALUES (1038, '客户已购产品删除', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedDelete', 10);
INSERT INTO `permission` VALUES (1039, '客户已购产品修改', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedUpdate', 10);
INSERT INTO `permission` VALUES (1040, '客户已购产品添加方法', 'App\\Http\\Controllers\\Admin\\CustomerController@purchasedCreate', 10);

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '设备序列号sn/mac号',
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '产品名称',
  `model` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '设备型号',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '安装地址',
  `rate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '带宽',
  `ip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT 'ip(json格式可多个)',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '产品状态-10正式 20备份 30测试',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1005 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '产品表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1001, '00E0671C95BA', '路由器', 's1960', '唐山点', '10M', 'eth3:169.254.99.1', '备注', 10, '2020-07-17 06:51:58', '2020-11-18 09:41:52');
INSERT INTO `product` VALUES (1002, 'E43A6E0BD681', '路由器', 's1960', '枣阳点', '4M', 'eth3:169.254.99.1', '备注', 10, '2020-07-17 06:51:58', '2020-11-02 06:02:07');
INSERT INTO `product` VALUES (1003, '00E06720D93C', '路由器', 's1960', '肇庆点', '8M', 'eth0:172.16.160.240,eth3:169.254.99.1', '备注', 10, '2020-07-17 06:51:58', '2020-11-02 06:02:07');
INSERT INTO `product` VALUES (1004, '321321', '123', '123', '123', '123', 'eth0:192.168.0.3', '21312321312', 90, '2020-11-18 08:24:24', '2020-11-18 09:42:05');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rolename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '角色名',
  `sign` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '标识',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态/10正常/90删除',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `rolename`(`rolename`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1004 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES (1001, '超级管理员', 'administrator', 10);
INSERT INTO `role` VALUES (1002, '管理员', 'admin', 10);
INSERT INTO `role` VALUES (1003, '普通用户', 'customer', 10);

-- ----------------------------
-- Table structure for role_permission
-- ----------------------------
DROP TABLE IF EXISTS `role_permission`;
CREATE TABLE `role_permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色id',
  `pid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '权限id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1543 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '角色权限分配表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_permission
-- ----------------------------
INSERT INTO `role_permission` VALUES (1187, '1003', '1001');
INSERT INTO `role_permission` VALUES (1188, '1003', '1002');
INSERT INTO `role_permission` VALUES (1189, '1003', '1003');
INSERT INTO `role_permission` VALUES (1190, '1003', '1004');
INSERT INTO `role_permission` VALUES (1191, '1003', '1005');
INSERT INTO `role_permission` VALUES (1192, '1003', '1006');
INSERT INTO `role_permission` VALUES (1193, '1003', '1007');
INSERT INTO `role_permission` VALUES (1322, '1002', '1001');
INSERT INTO `role_permission` VALUES (1323, '1002', '1002');
INSERT INTO `role_permission` VALUES (1324, '1002', '1003');
INSERT INTO `role_permission` VALUES (1325, '1002', '1004');
INSERT INTO `role_permission` VALUES (1326, '1002', '1005');
INSERT INTO `role_permission` VALUES (1327, '1002', '1006');
INSERT INTO `role_permission` VALUES (1328, '1002', '1007');
INSERT INTO `role_permission` VALUES (1329, '1002', '1008');
INSERT INTO `role_permission` VALUES (1330, '1002', '1009');
INSERT INTO `role_permission` VALUES (1331, '1002', '1010');
INSERT INTO `role_permission` VALUES (1332, '1002', '1011');
INSERT INTO `role_permission` VALUES (1333, '1002', '1012');
INSERT INTO `role_permission` VALUES (1334, '1002', '1013');
INSERT INTO `role_permission` VALUES (1335, '1002', '1014');
INSERT INTO `role_permission` VALUES (1336, '1002', '1015');
INSERT INTO `role_permission` VALUES (1337, '1002', '1016');
INSERT INTO `role_permission` VALUES (1338, '1002', '1017');
INSERT INTO `role_permission` VALUES (1339, '1002', '1018');
INSERT INTO `role_permission` VALUES (1340, '1002', '1019');
INSERT INTO `role_permission` VALUES (1341, '1002', '1020');
INSERT INTO `role_permission` VALUES (1342, '1002', '1021');
INSERT INTO `role_permission` VALUES (1343, '1002', '1022');
INSERT INTO `role_permission` VALUES (1344, '1002', '1040');
INSERT INTO `role_permission` VALUES (1503, '1001', '1001');
INSERT INTO `role_permission` VALUES (1504, '1001', '1002');
INSERT INTO `role_permission` VALUES (1505, '1001', '1003');
INSERT INTO `role_permission` VALUES (1506, '1001', '1004');
INSERT INTO `role_permission` VALUES (1507, '1001', '1005');
INSERT INTO `role_permission` VALUES (1508, '1001', '1006');
INSERT INTO `role_permission` VALUES (1509, '1001', '1007');
INSERT INTO `role_permission` VALUES (1510, '1001', '1008');
INSERT INTO `role_permission` VALUES (1511, '1001', '1009');
INSERT INTO `role_permission` VALUES (1512, '1001', '1010');
INSERT INTO `role_permission` VALUES (1513, '1001', '1011');
INSERT INTO `role_permission` VALUES (1514, '1001', '1012');
INSERT INTO `role_permission` VALUES (1515, '1001', '1013');
INSERT INTO `role_permission` VALUES (1516, '1001', '1014');
INSERT INTO `role_permission` VALUES (1517, '1001', '1015');
INSERT INTO `role_permission` VALUES (1518, '1001', '1016');
INSERT INTO `role_permission` VALUES (1519, '1001', '1017');
INSERT INTO `role_permission` VALUES (1520, '1001', '1018');
INSERT INTO `role_permission` VALUES (1521, '1001', '1019');
INSERT INTO `role_permission` VALUES (1522, '1001', '1020');
INSERT INTO `role_permission` VALUES (1523, '1001', '1021');
INSERT INTO `role_permission` VALUES (1524, '1001', '1022');
INSERT INTO `role_permission` VALUES (1525, '1001', '1023');
INSERT INTO `role_permission` VALUES (1526, '1001', '1024');
INSERT INTO `role_permission` VALUES (1527, '1001', '1025');
INSERT INTO `role_permission` VALUES (1528, '1001', '1026');
INSERT INTO `role_permission` VALUES (1529, '1001', '1027');
INSERT INTO `role_permission` VALUES (1530, '1001', '1028');
INSERT INTO `role_permission` VALUES (1531, '1001', '1029');
INSERT INTO `role_permission` VALUES (1532, '1001', '1030');
INSERT INTO `role_permission` VALUES (1533, '1001', '1031');
INSERT INTO `role_permission` VALUES (1534, '1001', '1032');
INSERT INTO `role_permission` VALUES (1535, '1001', '1033');
INSERT INTO `role_permission` VALUES (1536, '1001', '1034');
INSERT INTO `role_permission` VALUES (1537, '1001', '1035');
INSERT INTO `role_permission` VALUES (1538, '1001', '1036');
INSERT INTO `role_permission` VALUES (1539, '1001', '1037');
INSERT INTO `role_permission` VALUES (1540, '1001', '1038');
INSERT INTO `role_permission` VALUES (1541, '1001', '1039');
INSERT INTO `role_permission` VALUES (1542, '1001', '1040');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '账号/用户名称',
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `address` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '公司地址',
  `status` int(11) NOT NULL DEFAULT 10 COMMENT '状态/10正常/20即将到期/90删除',
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间/账号创建时间',
  `updated_at` datetime(0) NULL DEFAULT NULL COMMENT '修改时间/用户资料修改时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `username`(`username`) USING BTREE,
  INDEX `email`(`email`(50)) USING BTREE,
  INDEX `mobile`(`mobile`) USING BTREE,
  INDEX `company`(`company`(50)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1017 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1001, 'admin', '4297f44b13955235245b2497399d7a93', '上海双于通信有限公司1', '12345671@qq.com', '18888888888', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-29 07:41:29');
INSERT INTO `user` VALUES (1002, 'shuangyu0011', 'e10adc3949ba59abbe56e057f20f883e', '上海双于通信有限公司2', '12345672@qq.com', '18888888882', '123', 10, '2020-07-17 14:51:58', '2020-11-02 02:08:09');
INSERT INTO `user` VALUES (1003, 'shuangyu3', '4297f44b13955235245b2497399d7a93', '123', '123', '123', '123', 10, '2020-07-17 14:51:58', '2020-11-02 02:19:13');
INSERT INTO `user` VALUES (1004, 'shuangyu4', 'e10adc3949ba59abbe56e057f20f883e', '上海双于通信有限公司4', '12345674@qq.com', '18888888884', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-10-29 02:32:37');
INSERT INTO `user` VALUES (1005, 'shuangyu5', 'e10adc3949ba59abbe56e057f20f883e', '上海双于通信有限公司5', '12345675@qq.com', '18888888885', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-17 14:51:49');
INSERT INTO `user` VALUES (1006, 'shuangyu6', 'e10adc3949ba59abbe56e057f20f883e', '上海双于通信有限公司6', '12345676@qq.com', '18888888886', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-17 14:51:49');
INSERT INTO `user` VALUES (1007, 'shuangyu7', 'e10adc3949ba59abbe56e057f20f883e', '上海双于通信有限公司7', '12345677@qq.com', '18888888887', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-17 14:51:49');
INSERT INTO `user` VALUES (1008, 'shuangyu8', 'e10adc3949ba59abbe56e057f20f883e', '上海双于通信有限公司8', '12345678@qq.com', '18888888880', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-17 14:51:49');
INSERT INTO `user` VALUES (1009, 'wjg123111', '97c2f3947dd25ef98151e9b0dbd32a3a', '上海双于通信有限公司8', '12345678@qq.com', '18888888880', '上海市真北路321312312312号19楼', 10, '2020-07-17 14:51:58', '2020-07-17 14:51:49');
INSERT INTO `user` VALUES (1010, 'wjg999', '64b64250e0ecad635ea7195e3bdf72d7', 'wjg999', 'wjg999@qq.com', '19999999999', 'wjg999', 10, '2020-07-30 06:12:53', '2020-07-30 06:12:53');
INSERT INTO `user` VALUES (1011, 'wjg123', '4297f44b13955235245b2497399d7a93', '上海双于通信有限公司', '604666621@qq.com', '18621324504', '上海市', 10, '2020-08-11 01:18:04', '2020-08-11 01:18:04');
INSERT INTO `user` VALUES (1012, 'admin12311', '4297f44b13955235245b2497399d7a93', '123123', '123123@qq.com', '19988888888', '123123', 10, '2020-11-02 02:38:59', '2020-11-02 02:40:32');
INSERT INTO `user` VALUES (1013, 'admin333', '4297f44b13955235245b2497399d7a93', '123123', '123123@qq.com', '12346465456', '123123', 10, '2020-11-02 02:41:16', '2020-11-02 02:41:16');
INSERT INTO `user` VALUES (1015, 'admin55', '4297f44b13955235245b2497399d7a93', '123', '12312@qq.com', '21313123213', '123', 90, '2020-11-02 02:51:08', '2020-11-02 02:53:44');
INSERT INTO `user` VALUES (1016, 'harvey', '8f9cf3f5789e16124f38936954a98668', '双于', '604666621@qq.com', '18621324504', '上海市普陀区', 10, '2020-11-10 09:29:17', '2020-11-10 09:29:17');

-- ----------------------------
-- Table structure for user_role
-- ----------------------------
DROP TABLE IF EXISTS `user_role`;
CREATE TABLE `user_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `rid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '角色ID',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1154 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户角色分配表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role
-- ----------------------------
INSERT INTO `user_role` VALUES (1030, 1010, '1001');
INSERT INTO `user_role` VALUES (1031, 1010, '1002');
INSERT INTO `user_role` VALUES (1032, 1010, '1003');
INSERT INTO `user_role` VALUES (1033, 1010, '1001');
INSERT INTO `user_role` VALUES (1034, 1010, '1002');
INSERT INTO `user_role` VALUES (1035, 1010, '1003');
INSERT INTO `user_role` VALUES (1053, 1003, '1001');
INSERT INTO `user_role` VALUES (1054, 1003, '1002');
INSERT INTO `user_role` VALUES (1055, 1003, '1003');
INSERT INTO `user_role` VALUES (1069, 1011, '1001');
INSERT INTO `user_role` VALUES (1070, 1011, '1002');
INSERT INTO `user_role` VALUES (1071, 1011, '1003');
INSERT INTO `user_role` VALUES (1124, 1002, '1001');
INSERT INTO `user_role` VALUES (1125, 1002, '1002');
INSERT INTO `user_role` VALUES (1126, 1002, '1003');
INSERT INTO `user_role` VALUES (1130, 1004, '1001');
INSERT INTO `user_role` VALUES (1131, 1004, '1002');
INSERT INTO `user_role` VALUES (1132, 1004, '1003');
INSERT INTO `user_role` VALUES (1141, 1012, '1001');
INSERT INTO `user_role` VALUES (1142, 1012, '1002');
INSERT INTO `user_role` VALUES (1143, 1012, '1003');
INSERT INTO `user_role` VALUES (1145, 1015, '1001');
INSERT INTO `user_role` VALUES (1146, 1015, '1002');
INSERT INTO `user_role` VALUES (1147, 1015, '1003');
INSERT INTO `user_role` VALUES (1148, 1001, '1001');
INSERT INTO `user_role` VALUES (1149, 1001, '1002');
INSERT INTO `user_role` VALUES (1150, 1001, '1003');
INSERT INTO `user_role` VALUES (1151, 1016, '1001');
INSERT INTO `user_role` VALUES (1152, 1016, '1002');
INSERT INTO `user_role` VALUES (1153, 1016, '1003');

SET FOREIGN_KEY_CHECKS = 1;
