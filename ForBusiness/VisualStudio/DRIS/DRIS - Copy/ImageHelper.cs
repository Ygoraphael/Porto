using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using System.Windows.Forms;
using System.Data;
using System.Data.SQLite;
using Kribo.StoringImages.Model;
using System.Drawing;

namespace EOR_DRIS
{

    class ImageHelper
    {

        public dBHelper helper = null;
        public string fileLocation = string.Empty;
        public bool isSucces = false;
        public int maxImageSize = 2097152;

        public string FileLocation
        {
            get { return fileLocation; }
            set
            {
                fileLocation = value;
            }
        }

        public Boolean GetSucces()
        {
            return isSucces;
        }

        public Kribo.StoringImages.Model.Image LoadImage()
        {
            Kribo.StoringImages.Model.Image image = null;

            OpenFileDialog dlg = new OpenFileDialog();
            dlg.InitialDirectory = @"C:\\";
            dlg.Title = "Seleccionar imagem";
            dlg.Filter = "Imagens  (*.jpg ; *.jpeg ; *.png ; *.gif ; *.tiff ; *.nef)|*.jpg;*.jpeg;*.png;*.gif;*.tiff;*.nef";
            dlg.ShowDialog();

            this.FileLocation = dlg.FileName;

            if (fileLocation == null || fileLocation == string.Empty)
                return image;

            if (FileLocation != string.Empty && fileLocation != null)
            {
                Cursor.Current = Cursors.WaitCursor;
                FileInfo info = new FileInfo(FileLocation);
                long fileSize = info.Length;
                maxImageSize = (Int32)fileSize;

                if (File.Exists(FileLocation))
                {
                    using (FileStream stream = File.Open(FileLocation, FileMode.Open))
                    {
                        BinaryReader br = new BinaryReader(stream);
                        byte[] data = br.ReadBytes(maxImageSize);
                        image = new Kribo.StoringImages.Model.Image(dlg.SafeFileName, data, fileSize);
                    }
                }
                Cursor.Current = Cursors.Default;
            }
            return image;
        }

        public Int32 InsertImage()
        {
            DataRow dataRow = null;
            isSucces = false;

            Kribo.StoringImages.Model.Image image = LoadImage();

            if (image == null) return 0;

            if (image != null)
            {
                string connectionString = dBFunctions.ConnectionStringSQLite;

                string commandText = "SELECT * FROM ImageStore WHERE 1=0";

                // Make a new object
                helper = new dBHelper(connectionString);
                {
                    // Load Data
                    if (helper.Load(commandText, "image_id") == true)
                    {
                        // Add a row and determin the row
                        helper.DataSet.Tables[0].Rows.Add(
                                           helper.DataSet.Tables[0].NewRow());
                        dataRow = helper.DataSet.Tables[0].Rows[0];

                        // Enter the given values
                        dataRow["imageFileName"] = image.FileName;
                        dataRow["imageBlob"] = image.ImageData;
                        dataRow["imageFileSizeBytes"] = image.FileSize;

                        try
                        {
                            // Save -> determin succes
                            if (helper.Save() == true)
                            {
                                isSucces = true;

                            }
                            else
                            {
                                isSucces = false;
                                MessageBox.Show("Error during Insertion");
                            }
                        }
                        catch (Exception ex)
                        {
                            // Show the Exception --> Dubbel Id/Name ?
                            MessageBox.Show(ex.Message);
                        }

                    }//END IF
                }
            }
            //return the new image_id
            return Convert.ToInt32(dataRow[0].ToString());
        }

        public void DeleteImage(Int32 imageID)
        {
            //Set variables
            isSucces = false;

            // Determin the ConnectionString
            string connectionString = dBFunctions.ConnectionStringSQLite;

            // Determin the DataAdapter = CommandText + Connection
            string commandText = "SELECT * FROM ImageStore WHERE image_id=" + imageID;

            // Make a new object
            helper = new dBHelper(connectionString);
            {
                // Load Data
                if (helper.Load(commandText, "image_id") == true)
                {
                    // Determin if the row was found
                    if (helper.DataSet.Tables[0].Rows.Count == 1)
                    {
                        // Found, delete row
                        helper.DataSet.Tables[0].Rows[0].Delete();
                        try
                        {
                            // Save -> determin succes
                            if (helper.Save() == true)
                            {
                                isSucces = true;
                            }
                            else
                            {
                                isSucces = false;
                                MessageBox.Show("Delete failed");
                            }
                        }
                        catch (Exception ex)
                        {
                            // Show the Exception --> Dubbel ContactId/Name ?
                            MessageBox.Show(ex.Message);
                        }
                    }
                }
            }
        }

        public void SaveAsImage(Int32 imageID)
        {
            //set variables
            DataRow dataRow = null;
            Kribo.StoringImages.Model.Image image = null;
            isSucces = false;

            // Displays a SaveFileDialog so the user can save the Image
            SaveFileDialog dlg = new SaveFileDialog();
            dlg.InitialDirectory = @"C:\\";
            dlg.Title = "Save Image File";
            //1
            dlg.Filter = "Tag Image File Format (*.tiff)|*.tiff";
            //2
            dlg.Filter += "|Graphics Interchange Format (*.gif)|*.gif";
            //3
            dlg.Filter += "|Portable Network Graphic Format (*.png)|*.png";
            //4
            dlg.Filter += "|Joint Photographic Experts Group Format (*.jpg)|*.jpg";
            //5
            dlg.Filter += "|Joint Photographic Experts Group Format (*.jpeg)|*.jpeg";
            //6
            dlg.Filter += "|Bitmap Image File Format (*.bmp)|*.bmp";
            //7
            dlg.Filter += "|Nikon Electronic Format (*.nef)|*.nef";
            dlg.ShowDialog();

            // If the file name is not an empty string open it for saving.
            if (dlg.FileName != "")
            {
                Cursor.Current = Cursors.WaitCursor;
                //making shore only one of the 7 is being used.
                //if not added the default extention to the filename
                string defaultExt = ".png";
                int pos = -1;
                string[] ext = new string[7] {".tiff", ".gif", ".png",
                                      ".jpg", ".jpeg", ".bmp", ".nef"};
                string extFound = string.Empty;
                string filename = dlg.FileName.Trim();
                for (int i = 0; i < ext.Length; i++)
                {
                    pos = filename.IndexOf(ext[i], pos + 1);
                    if (pos > -1)
                    {
                        extFound = ext[i];
                        break;
                    }
                }
                if (extFound == string.Empty) filename = filename + defaultExt;

                // Determin the ConnectionString
                string connectionString = dBFunctions.ConnectionStringSQLite;

                // Determin the DataAdapter = CommandText + Connection
                string commandText = "SELECT * FROM ImageStore WHERE image_id=" + imageID;

                // Make a new object
                helper = new dBHelper(connectionString);

                // Load the data
                if (helper.Load(commandText, "") == true)
                {
                    // Show the data in the datagridview
                    dataRow = helper.DataSet.Tables[0].Rows[0];
                    image = new Kribo.StoringImages.Model.Image(
                                      (string)dataRow["imageFileName"],
                                      (byte[])dataRow["imageBlob"],
                                      (long)dataRow["imageFileSizeBytes"]
                                      );

                    // Saves the Image via a FileStream created by the OpenFile method.
                    using (FileStream stream = new FileStream(filename, FileMode.Create))
                    {
                        BinaryWriter bw = new BinaryWriter(stream);
                        bw.Write(image.ImageData);
                        isSucces = true;
                    }
                }
                Cursor.Current = Cursors.Default;
            }

            if (isSucces)
            {
                MessageBox.Show("Save succesfull");
            }
            else
            {
                MessageBox.Show("Save failed");
            }
        }

    }


}
