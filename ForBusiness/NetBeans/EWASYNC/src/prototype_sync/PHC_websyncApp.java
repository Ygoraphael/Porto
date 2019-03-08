/*
 * PHC_websyncApp.java
 */

package prototype_sync;

import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;

/**
 * The main class of the application.
 */
public class PHC_websyncApp extends SingleFrameApplication {

    @Override protected void startup() {
        show(new PHC_websyncView(this));
    }

    @Override protected void configureWindow(java.awt.Window root) {
    }

    public static PHC_websyncApp getApplication() {
        return Application.getInstance(PHC_websyncApp.class);
    }

    public static void main(String[] args) {
        launch(PHC_websyncApp.class, args);
    }
}
