using System;
using System.Collections;
using Empox_GY_ClientB.Common;
using System.Data;
using System.Data.SqlClient;
using System.Text;
using Empox_GY_ClientB.Entity;
using System.Net;
using System.IO;
using System.IO.Compression;
using System.Web;
using System.Security.Cryptography;
using System.Collections.Generic;


namespace Empox_GY_ClientB.DataAccess
{
    /// <summary>
    /// clsSystemDB 的摘要说明。
    /// </summary>
    public class clsCERPSystemDB
    {
        private CERPDataOperate dtOperate;
        public clsCERPSystemDB()
        {
            dtOperate = new CERPDataOperate();
        }       

        public string GetDDsData(string shopcode, string starttime, string endtime, string whcode, int page, int page_size, string[] djbhs, string delivery)
        {
            string backstr = "";
            string signContent = "";
            string requestContent = "";
            string djbh = "";
            try
            {
                string cerpurl = AppPara.CERPURL;
                string appkey = AppPara.CERPAPPKEY;
                string sessionkey = AppPara.CERPSESSIONKEY;
                string method = "gy.erp.trade.deliverys.get";
                string sign = "";

                if (djbhs != null && djbhs.Length > 0)
                {
                    djbh = djbhs[0];
                }
                String baseContent = "{"
               + "\"appkey\":\"" + appkey + "\","
               + "\"method\":\"" + method + "\","
               + "\"page_no\":" + page + ","
               + "\"page_size\":" + page_size + ","
               + "\"sessionkey\":\"" + sessionkey + "\"";
                if (!string.IsNullOrWhiteSpace(shopcode))
                {
                    baseContent += "," + "\"shop_code\":\"" + shopcode + "\"";
                }
                if (!string.IsNullOrWhiteSpace(djbh))
                {
                    baseContent += "," + "\"code\":\"" + djbh + "\"";
                }
                if (!string.IsNullOrWhiteSpace(starttime))
                {
                    baseContent += "," + "\"start_delivery_date\":\"" + starttime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(endtime))
                {
                    baseContent += "," + "\"end_delivery_date\":\"" + endtime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(whcode))
                {
                    baseContent += "," + "\"warehouse_code\":\"" + whcode + "\"";
                }
                if (!string.IsNullOrWhiteSpace(delivery))
                {
                    baseContent += "," + "\"delivery\":\"" + delivery + "\"";
                }
                baseContent += "signplace";
                baseContent += "}";

                signContent = baseContent.Replace("signplace", "");
                sign = Sign(signContent);

                requestContent = baseContent.Replace("signplace", "," + "\"sign\":\"" + sign + "\"");
                //requestContent=
                backstr = RequestCERP(requestContent, cerpurl);
            }
            catch (Exception ex)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "GetDDsData--signContent[" + signContent + "],requestContent[" + requestContent + "],backstr[" + backstr + "]", ex);
                throw ex;
            }
            return backstr;
        }

        public string GetTHDsData(string shopcode, string starttime, string endtime, string whcode, int page, int page_size, string[] djbhs, string receive)
        {
            string backstr = "";
            string signContent = "";
            string requestContent = "";
            string djbh = "";
            try
            {
                string cerpurl = AppPara.CERPURL;
                string appkey = AppPara.CERPAPPKEY;
                string sessionkey = AppPara.CERPSESSIONKEY;
                string method = "gy.erp.trade.return.get";
                string sign = "";

                if (djbhs != null && djbhs.Length > 0)
                {
                    djbh = djbhs[0];
                }

                String baseContent = "{"
               + "\"appkey\":\"" + appkey + "\","
               + "\"method\":\"" + method + "\","
               + "\"page_no\":" + page + ","
               + "\"page_size\":" + page_size + ","
               + "\"sessionkey\":\"" + sessionkey + "\"";
                if (!string.IsNullOrWhiteSpace(shopcode))
                {
                    baseContent += "," + "\"shop_code\":\"" + shopcode + "\"";
                }
                if (!string.IsNullOrWhiteSpace(djbh))
                {
                    baseContent += "," + "\"code\":\"" + djbh + "\"";
                }
                if (!string.IsNullOrWhiteSpace(starttime))
                {
                    baseContent += "," + "\"in_begin_time\":\"" + starttime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(endtime))
                {
                    baseContent += "," + "\"in_end_time\":\"" + endtime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(receive))
                {
                    baseContent += "," + "\"receive\":\"" + receive + "\"";
                }
                if (!string.IsNullOrWhiteSpace(whcode))
                {
                    baseContent += "," + "\"warehouse_code\":\"" + whcode + "\"";
                }
                baseContent += "," + "\"cancel\":\"" + 0 + "\"";//0-未作废，1-已作废

                baseContent += "signplace";
                baseContent += "}";

                signContent = baseContent.Replace("signplace", "");
                sign = Sign(signContent);

                requestContent = baseContent.Replace("signplace", "," + "\"sign\":\"" + sign + "\"");

                backstr = RequestCERP(requestContent, cerpurl);
            }
            catch (Exception ex)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "GetTHDsData--signContent[" + signContent + "],requestContent[" + requestContent + "],backstr[" + backstr + "]", ex);
                throw ex;
            }
            return backstr;
        }

        public string GetCGRKDsData(string shopcode, string starttime, string endtime, string whcode, int page, int page_size, string[] djbhs, string status)
        {
            string backstr = "";
            string signContent = "";
            string requestContent = "";
            string djbh = "";
            try
            {
                string cerpurl = AppPara.CERPURL;
                string appkey = AppPara.CERPAPPKEY;
                string sessionkey = AppPara.CERPSESSIONKEY;
                string method = "gy.erp.purchase.arrive.get";
                string sign = "";
                if (djbhs != null && djbhs.Length > 0)
                {
                    djbh = djbhs[0];
                }
                String baseContent = "{"
               + "\"appkey\":\"" + appkey + "\","
               + "\"method\":\"" + method + "\","
               + "\"page_no\":" + page + ","
               + "\"page_size\":" + page_size + ","
               + "\"sessionkey\":\"" + sessionkey + "\"";
                if (!string.IsNullOrWhiteSpace(starttime))
                {
                    baseContent += "," + "\"start_approve\":\"" + starttime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(endtime))
                {
                    baseContent += "," + "\"end_approve\":\"" + endtime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(whcode))
                {
                    baseContent += "," + "\"warehouse_code\":\"" + whcode + "\"";
                }
                if (!string.IsNullOrWhiteSpace(djbh))
                {
                    baseContent += "," + "\"code\":\"" + djbh + "\"";
                }
                if (!string.IsNullOrWhiteSpace(status))
                {
                    baseContent += "," + "\"status\":\"" + status + "\"";
                }
                baseContent += "signplace";
                baseContent += "}";

                signContent = baseContent.Replace("signplace", "");
                sign = Sign(signContent);

                requestContent = baseContent.Replace("signplace", "," + "\"sign\":\"" + sign + "\"");

                backstr = RequestCERP(requestContent, cerpurl);
            }
            catch (Exception ex)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "GetCGRKDsData--signContent[" + signContent + "],requestContent[" + requestContent + "],backstr[" + backstr + "]", ex);
                throw ex;
            }
            return backstr;
        }

        public string GetTHCKDsData(string shopcode, string starttime, string endtime, string whcode, int page, int page_size, string[] djbhs, string status)
        {
            string backstr = "";
            string signContent = "";
            string requestContent = "";
            string djbh = "";
            try
            {
                string cerpurl = AppPara.CERPURL;
                string appkey = AppPara.CERPAPPKEY;
                string sessionkey = AppPara.CERPSESSIONKEY;
                string method = "gy.erp.purchase.return.get";
                string sign = "";
                if (djbhs != null && djbhs.Length > 0)
                {
                    djbh = djbhs[0];
                }

                String baseContent = "{"
               + "\"appkey\":\"" + appkey + "\","
               + "\"method\":\"" + method + "\","
               + "\"page_no\":" + page + ","
               + "\"page_size\":" + page_size + ","
               + "\"code\":\"" + djbh + "\","
               + "\"sessionkey\":\"" + sessionkey + "\"";
                if (!string.IsNullOrWhiteSpace(starttime))
                {
                    baseContent += "," + "\"start_approve\":\"" + starttime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(endtime))
                {
                    baseContent += "," + "\"end_approve\":\"" + endtime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(whcode))
                {
                    baseContent += "," + "\"warehouse_code\":\"" + whcode + "\"";
                }
                if (!string.IsNullOrWhiteSpace(status))
                {
                    baseContent += "," + "\"status\":\"" + status + "\"";
                }
                baseContent += "signplace";
                baseContent += "}";

                signContent = baseContent.Replace("signplace", "");
                sign = Sign(signContent);

                requestContent = baseContent.Replace("signplace", "," + "\"sign\":\"" + sign + "\"");

                backstr = RequestCERP(requestContent, cerpurl);
            }
            catch (Exception ex)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "GetTHCKDsData--signContent[" + signContent + "],requestContent[" + requestContent + "],backstr[" + backstr + "]", ex);
                throw ex;
            }
            return backstr;
        }

        public string GetSPYCDsData(string starttime, string endtime, string outwhcode, string inwhcode, int page, int page_size, string[] djbhs, string status_in)
        {
            string backstr = "";
            string signContent = "";
            string requestContent = "";
            string djbh = "";
            try
            {
                string cerpurl = AppPara.CERPURL;
                string appkey = AppPara.CERPAPPKEY;
                string sessionkey = AppPara.CERPSESSIONKEY;
                string method = "gy.erp.stock.transfer.get";
                string sign = "";
                if (djbhs != null && djbhs.Length > 0)
                {
                    djbh = djbhs[0];
                }
                String baseContent = "{"
               + "\"appkey\":\"" + appkey + "\","
               + "\"method\":\"" + method + "\","
               + "\"page_no\":" + page + ","
               + "\"page_size\":" + page_size + ","
               + "\"sessionkey\":\"" + sessionkey + "\"";
                if (!string.IsNullOrWhiteSpace(djbh))
                {
                    baseContent += "," + "\"code\":\"" + djbh + "\"";
                }
                if (!string.IsNullOrWhiteSpace(starttime))
                {
                    baseContent += "," + "\"start_create\":\"" + starttime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(endtime))
                {
                    baseContent += "," + "\"end_create\":\"" + endtime + "\"";
                }
                if (!string.IsNullOrWhiteSpace(outwhcode))
                {
                    baseContent += "," + "\"warehouse_out\":\"" + outwhcode + "\"";
                }
                if (!string.IsNullOrWhiteSpace(inwhcode))
                {
                    baseContent += "," + "\"warehouse_in\":\"" + inwhcode + "\"";
                }               
                if (!string.IsNullOrWhiteSpace(status_in))
                {
                    baseContent += "," + "\"status_in\":\"" + status_in + "\"";
                }
                baseContent += "signplace";
                baseContent += "}";

                signContent = baseContent.Replace("signplace", "");
                sign = Sign(signContent);

                requestContent = baseContent.Replace("signplace", "," + "\"sign\":\"" + sign + "\"");

                backstr = RequestCERP(requestContent, cerpurl);
            }
            catch (Exception ex)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "GetSPYCDsData--signContent[" + signContent + "],requestContent[" + requestContent + "],backstr[" + backstr + "]", ex);
                throw ex;
            }
            return backstr;
        }                

        #region Sign
        public String Sign(string json)
        {
            string secret = AppPara.CERPSECRET;
            //将sign字段与值去掉
            //json.remove("sign");
            StringBuilder enValue = new StringBuilder();
            //前后加上secret
            enValue.Append(secret);
            //enValue.Append(json.toString());
            enValue.Append(json.ToString());
            enValue.Append(secret);
            // 使用MD5加密
            byte[] bytes = encryptMD5(enValue.ToString());
            // 把二进制转化为大写的十六进制
            return byte2hex(bytes);
        }

        private byte[] encryptMD5(String data)
        {
            byte[] bytes = null;
            try
            {
                MD5 md5 = new MD5CryptoServiceProvider();
                bytes = md5.ComputeHash(System.Text.Encoding.UTF8.GetBytes(data));

                //MessageDigest md = MessageDigest.getInstance("MD5");
                //bytes = md.digest(data.getBytes("UTF-8"));
            }
            catch (Exception e)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "encryptMD5", e);
            }
            return bytes;
        }
        private String byte2hex(byte[] bytes)
        {
            string md5Str = "0123456789ABCDEF";
            string sign = string.Empty;
            for (int i = 0; i < bytes.Length; i++)
            {
                int a = 0xf & bytes[i] >> 4;
                int b = bytes[i] & 0xf;
                sign += md5Str.Substring(0xf & bytes[i] >> 4, 1) + md5Str[bytes[i] & 0xf];
            }
            return sign.ToString();
        }
        #endregion

        public string RequestCERP(string jsondata, string cerpurl)
        {
            string backstr = "";
            try
            {
                backstr = dtOperate.DoRequest(forCERP(jsondata), cerpurl);
            }
            catch (Exception ex)
            {
                new clsWriterErr().writerErr("clsCERPSystemDB", "GetCERPData--jsondata[" + jsondata + "]--backstr[" + backstr + "]", ex);
                throw ex;
            }
            return backstr;
        }
       
    }
}
