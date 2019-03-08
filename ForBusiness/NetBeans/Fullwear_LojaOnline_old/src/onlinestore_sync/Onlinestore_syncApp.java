/*
 * Vmflex_websyncApp.java
 */

package onlinestore_sync;

import org.jdesktop.application.Application;
import org.jdesktop.application.SingleFrameApplication;

/**
 * The main class of the application.
 */
public class Onlinestore_syncApp extends SingleFrameApplication {

    @Override protected void startup() {
        show(new Onlinestore_syncView(this));
    }

    @Override protected void configureWindow(java.awt.Window root) {
    }

    public static Onlinestore_syncApp getApplication() {
        return Application.getInstance(Onlinestore_syncApp.class);
    }

    public static void main(String[] args) {
        launch(Onlinestore_syncApp.class, args);
    }
}
