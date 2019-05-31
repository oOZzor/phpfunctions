using System;
using System.Data;
using System.Data.SqlClient;
using Empox_GY_ClientB.Common;
using System.Configuration;
using System.Net;
using System.Text;
using System.IO;
using System.Web;
using System.IO.Compression;
using System.Text.RegularExpressions;
using ICSharpCode.SharpZipLib.GZip;
using ICSharpCode.SharpZipLib.Zip.Compression.Streams;

namespace Empox_GY_ClientB.DataAccess
{
    /// <summary>
    /// DataOperate 的摘要说明。
    /// </summary>
    public class CERPDataOperate
    {
        private SqlDataAdapter da;
        private DataSet ds;
        private SqlConnection conn;
        private SqlCommand cmd;

        public CERPDataOperate()
        {
            //conn = new SqlConnection("Data Source=192.168.1.98,1433;NetWork Library=DBMSSOCN;Initial Catalog=ec-erp-test;User ID=sa;Password=123;");
            conn = new SqlConnection(AppPara.connStr);
        }

        private HttpWebRequest NewRequest(string requestUrl)
        {
            HttpWebRequest newRequest = WebRequest.Create(requestUrl) as HttpWebRequest;

            newRequest.Method = "POST";
            newRequest.Accept = "*/* ";
            newRequest.UserAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; CIBA; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729; InfoPath.1)";
            //newRequest.UserAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; .NET CLR 1.1.4322)";
            newRequest.ContentType = "application/json;charset=utf-8";
            newRequest.ReadWriteTimeout = 15000;
            newRequest.Headers.Add("Accept-Language", "zh-cn");
            newRequest.Headers.Add("Accept-Encoding", "gzip,deflate");
            return newRequest;
        }

        private string SignHeader()
        {
            //DateTime now = DateTime.Now;
            //string header = "sip_appkey=" + FormatStringToUrl(AppPara.portalUid, true);
            //header += "&sip_timestamp=" + FormatStringToUrl(now.ToString(AppPara.TIMEFORMAT), false);
            //header += "&sip_sign=" + GetSign(AppPara.portalUid, AppPara.portalPwd, now);
            //return header;
            string header = "";

            return header;
        }

        public string FormatStringToUrl(string data, bool isAppWord)
        {

            string afterFmt = data;
            //if (!isAppWord)
            //{
            //    afterFmt = HttpUtility.UrlEncode(afterFmt).ToUpper();
            //}
            //afterFmt = afterFmt.Replace("+", "%20");
            //afterFmt = afterFmt.Replace(" ", "%20");
            //afterFmt = afterFmt.Replace("@", "%40");
            //afterFmt = afterFmt.Replace(".", "%2E");
            //afterFmt = afterFmt.Replace("-", "%2D");
            //afterFmt = afterFmt.Replace(":", "%3A");
            //afterFmt = afterFmt.Replace("[", "%5B");
            //afterFmt = afterFmt.Replace("{", "%7B");
            //afterFmt = afterFmt.Replace("}", "%7D");
            //afterFmt = afterFmt.Replace("]", "%5D");
            //afterFmt = afterFmt.Replace("\"", "%22");
            //afterFmt = afterFmt.Replace("'", "%22");
            //afterFmt = afterFmt.Replace(",", "%2C");
            //afterFmt = afterFmt.Replace("_", "%5F");
            //afterFmt = afterFmt.Replace("\\", "%5C");
            ////afterFmt = afterFmt.Replace("=", "%3D");
            return afterFmt;
        }

        public string DoRequest(string data, string OMSUrl)
        {
            string respStr = "";

            HttpWebRequest request;
            HttpWebResponse response;
            try
            {
                request = NewRequest(OMSUrl);
                respStr = SignHeader();
                //respStr += FormatStringToUrl(data, true);
                respStr += data;
                byte[] dataBytes = Encoding.UTF8.GetBytes(respStr);
                request.ContentLength = dataBytes.Length;
                using (Stream stream = request.GetRequestStream())
                {
                    stream.Write(dataBytes, 0, dataBytes.Length);
                    stream.Close();
                }
                response = request.GetResponse() as HttpWebResponse;
                string errorCode = response.Headers.Get(0);

                //using (Stream stream = response.GetResponseStream())
                using (Stream stream = Gzip(response))
                {
                    StreamReader sr = new StreamReader(stream, Encoding.UTF8, true);
                    respStr = sr.ReadToEnd();
                    sr.Close();
                    sr.Dispose();
                    stream.Close();
                    stream.Dispose();
                    request.Abort();
                }
            }
            catch (Exception ex)
            {
                respStr = "{\"BatchID\":null,\"LifungResult\":null,\"exceptionMsg\":\"" + ex.Message + "\",\"message\":null,\"result\":false}";
            }
            return respStr;
        }

        private static Stream Gzip(HttpWebResponse HWResp)
        {
            Stream stream1 = null;
            if (HWResp.ContentEncoding == "gzip")
            {
                stream1 = new GZipInputStream(HWResp.GetResponseStream());
            }
            else
            {
                if (HWResp.ContentEncoding == "deflate")
                {
                    stream1 = new InflaterInputStream(HWResp.GetResponseStream());
                }
            }
            if (stream1 == null)
            {
                return HWResp.GetResponseStream();
            }
            MemoryStream stream2 = new MemoryStream();
            int count = 0x800;
            byte[] buffer = new byte[0x800];
            goto A;
        A:
            count = stream1.Read(buffer, 0, count);
            if (count > 0)
            {
                stream2.Write(buffer, 0, count);
                goto A;
            }
            stream2.Seek((long)0, SeekOrigin.Begin);
            return stream2;
        }
        
    }
}