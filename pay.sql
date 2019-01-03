SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for qr_log
-- ----------------------------
DROP TABLE IF EXISTS `qr_log`;
CREATE TABLE `qr_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `ip` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'ip',
  `driver` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '设备',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '内容',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for qr_pay
-- ----------------------------
DROP TABLE IF EXISTS `qr_pay`;
CREATE TABLE `qr_pay`  (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'id',
  `qq_pay` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT 'qq',
  `ali_pay` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '支付宝',
  `wx_pay` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '微信',
  `nickname` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL COMMENT '昵称',
  `create_time` datetime(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '时间',
  `count` bigint(20) NOT NULL DEFAULT 0 COMMENT '次数',
  `isDelete` int(1) NOT NULL DEFAULT 0 COMMENT '删除位',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
