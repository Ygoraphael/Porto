<%@ Page Title="Home Page" Language="vb" MasterPageFile="~/Site.Master" AutoEventWireup="false"
    CodeBehind="Default.aspx.vb" Inherits="OhYeah._Default" %>

<asp:Content ID="HeaderContent" runat="server" ContentPlaceHolderID="HeadContent">
<script language="javascript" type="text/javascript" src="Js/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="Js/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="Styles/jquery.jqplot.min.css">
<script class="include" language="javascript" type="text/javascript" src="Js/jqplot.canvasTextRenderer.min.js"></script>
<script class="include" language="javascript" type="text/javascript" src="Js/jqplot.canvasAxisLabelRenderer.min.js"></script>
</asp:Content>
<asp:Content ID="BodyContent" runat="server" ContentPlaceHolderID="MainContent">
    <h2>
        Helena's Graphs!
    </h2>
    <div id="chart1"></div>
    <% 
        If tmp_string <> "" Then
    %>
    <script>
        $(document).ready(function () {
            var plot1 = $.jqplot('chart1', [[ <%=tmp_string %> ]]);
        });
    </script>
    <% 
    End If
    %>

    <asp:Button ID="faz_contagem" text="Clica Aqui" runat=server />
</asp:Content>
