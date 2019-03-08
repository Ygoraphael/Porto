/*
 * Fullsport_app_eventosApp.java
 */

package Fullsport_app_eventos;

import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;

/**
 * The main class of the application.
 */
public class Fullsport_app_eventosApp extends SingleFrameApplication {

    /**
     * At startup create and show the main frame of the application.
     */
    @Override protected void startup() {
        show(new Fullsport_app_eventosView(this));
    }

    /**
     * This method is to initialize the specified window by injecting resources.
     * Windows shown in our application come fully initialized from the GUI
     * builder, so this additional configuration is not needed.
     */
    @Override protected void configureWindow(java.awt.Window root) {
    }

    /**
     * A convenient static getter for the application instance.
     * @return the instance of Fullsport_app_eventosApp
     */
    public static Fullsport_app_eventosApp getApplication() {
        return Application.getInstance(Fullsport_app_eventosApp.class);
    }

    /**
     * Main method launching the application.
     */
    public static void main(String[] args) {
        launch(Fullsport_app_eventosApp.class, args);
    }
}
