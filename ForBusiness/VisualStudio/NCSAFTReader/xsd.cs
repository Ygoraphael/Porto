using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Reflection;
using System.IO;
using System.Resources;

namespace NCSAFTReader
{
    public class xsd
    {
        public string xsd_01_simplificado;
        public string xsd_01_geral;
        public string xsd_02_simplificado;
        public string xsd_02_geral;
        public string xsd_03_simplificado;
        public string xsd_03_geral;

        public xsd()
        {
            xsd_01_simplificado = NCSAFTReader.Properties.Resources.xsd_01_simplificado;
            xsd_01_geral = NCSAFTReader.Properties.Resources.xsd_01_geral;
            xsd_02_simplificado = NCSAFTReader.Properties.Resources.xsd_02_simplificado;
            xsd_02_geral = NCSAFTReader.Properties.Resources.xsd_02_geral;
            xsd_03_simplificado = NCSAFTReader.Properties.Resources.xsd_03_simplificado;
            xsd_03_geral = NCSAFTReader.Properties.Resources.xsd_03_geral;
        }
    }
}
