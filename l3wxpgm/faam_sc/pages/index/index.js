//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    //motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },

  //点击收货管理二维码
  shButtonTap: function () {
    // 允许从相机和相册扫码
    wx.scanCode({
      success: (respScanCode) => {

        //获得位置信息
        wx.getLocation({
          type: 'wgs84',
          success: function (respGetLocation) {
            var latitude = (respGetLocation.latitude) * 1000000
            var longitude = (respGetLocation.longitude) * 1000000

            wx.getUserInfo({
              success: function (res) {
                var userInfo = res.userInfo
                var nickName = userInfo.nickName
                //发起网络请求
                wx.request({
                  url: 'https://h5.aiqiworld.com/xhzn/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',    //爱启云
                  //url: 'http://www.hkrob.com/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',  //小慧云
                  //url: 'http://127.0.0.1/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',      //本地
                  data: {
                    codeType: 'QRCODE_SH', //收货二维码
                    scanCode: respScanCode.result,
                    latitude: latitude,
                    longitude: longitude,
                    nickName: nickName
                  },
                  method: "POST",
                  header: {
                    'content-type': 'application/json' // 默认值
                    //"content-type": "application/x-www-form-urlencoded"
                  },
                  success: function (wxResp) {
                    wx.showToast({
                      title: '收货信息',
                      icon: 'succes',
                      duration: 500,
                      mask: true
                    })
                  },
                  fail: function (wxResp) {
                    wx.showToast({
                      title: '您好,扫描失败',
                      icon: 'succes',
                      duration: 1000,
                      mask: true
                    })
                  }
                })//wx.request
              }
            }) //wx.getUserInfo
          }
        })//wx.getLocation
      }
    })//wx.scanCode
  },

  //点击生产管理二维码
  scButtonTap: function () {
    // 允许从相机和相册扫码
    wx.scanCode({
      success: (respScanCode) => {

        wx.getUserInfo({
          success: function (res) {
            var userInfo = res.userInfo
            var nickName = userInfo.nickName
            //发起网络请求
            wx.request({
              url: 'https://h5.aiqiworld.com/xhzn/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',    //爱启云
              //url: 'http://www.hkrob.com/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',  //小慧云
              //url: 'http://127.0.0.1/mfunhcu/l1mainentry/cloud_callback_wechat_xcx.php',      //本地
              data: {
                codeType: 'QRCODE_SC', //生产二维码
                scanCode: respScanCode.result,
                latitude: 0,
                longitude: 0,
                nickName: nickName
              },
              method: "POST",
              header: {
                'content-type': 'application/json' // 默认值
                //"content-type": "application/x-www-form-urlencoded"
              },
              success: function (wxResp) {
                var flag = wxResp.data.flag
                if (flag == true) {
                  wx.vibrateLong();
                  wx.playBackgroundAudio({
                    //播放地址
                    dataUrl: 'https://h5.aiqiworld.com/xhzn/mfunhcu/l4faamui/video/wechat.mp3',
                    //dataUrl: 'http://127.0.0.1/mfunhcu/l4faamui/video/wechat.mp3',
                    title: '提示音',
                  })
                  wx.showToast({
                    title: wxResp.data.message,
                    icon: 'succes',
                    duration: 500,
                    mask: true
                  })
                }
                else {
                  wx.showModal({
                    title: '提示信息',
                    content: wxResp.data.message
                  })
                }
              },
              fail: function (wxResp) {
                wx.showToast({
                  title: '您好,扫描失败',
                  icon: 'succes',
                  duration: 1000,
                  mask: true
                })
              }
            })//wx.request
          }
        }) //wx.getUserInfo
      }
    })//wx.scanCode
  },

  onLoad: function () {
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse){
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },
  getUserInfo: function(e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  }
})
